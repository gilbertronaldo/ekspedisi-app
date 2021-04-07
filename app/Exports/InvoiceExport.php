<?php

namespace App\Exports;

use App\MsOfficeBranch;
use App\MsRecipient;
use App\TrBapb;
use App\TrInvoice;
use App\TrPajak;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Events\BeforeWriting;
use Maatwebsite\Excel\Sheet;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;

/**
 * Class BapbExport
 *
 * @package App\Exports
 */
class InvoiceExport implements FromView, WithEvents
{
    private $invoiceId;
    private $input;

    public function __construct($noContainer)
    {
        $this->invoiceId = (int)$noContainer;

        $invoice = TrInvoice::findOrFail($this->invoiceId);

        $bapb = $this->getItems($this->invoiceId);

        $recipient = null;
        if (! empty($bapb)) {
            $recipient = MsRecipient::with('city')->findOrFail(
                $bapb[0]->recipient_id
            );
        }


        $cityCodeRecipient = $recipient->city->city_code;

        $officeBranch = MsOfficeBranch::whereCityCode($cityCodeRecipient, $invoice->is_pph);

        collect($bapb)->each(
            function ($i) {
                $i->senders = implode(", ", json_decode($i->senders));
                $i->costs = json_decode($i->costs);

                if ($i->tagih_di !== 'recipient') {
                    $i->harga += $i->price_document;
                }
            }
        );

        $subTotal = collect($bapb)->reduce(
            function ($i, $j) {
                return $i + $j->harga;
            }
        );

        $costTotal = collect($bapb)->reduce(
            function ($i, $j) {
                return $i + $j->cost;
            }
        );

        $pph23 = 0;
        $pph = 0;
        if ($invoice->is_pph === true) {
            $pajak = TrPajak::query()
                ->where('date', '=', $invoice->created_at->toDateString())
                ->first();

            if ($pajak) {
                $pph23 = $pajak->pph_23;
            } else {
                $pph23 = 2;
            }

            $pph = round($subTotal * $pph23 / 100, 0);
        }

        $totalAll = $subTotal - $pph + $costTotal;

        $this->input = [
            'invoice'      => $invoice,
            'bapbList'     => $bapb,
            'subTotal'     => $subTotal,
            'totalPph'     => $pph,
            'totalAll'     => $totalAll,
            'recipient'    => $recipient,
            'officeBranch' => $officeBranch,
            'pph23'        => $pph23,
        ];

    }

    /**
     * @return View
     */
    public function view(): View
    {
        return view('invoice.excel.invoice', $this->input);
    }

    private function getItems($invoiceId)
    {
        $bapb = DB::select(
            "
          SELECT A.invoice_id, A.invoice_no, A.is_pph,
                 C.bapb_id, C.bapb_no, C.tagih_di, H.recipient_id,
                 COALESCE(C.harga,0) AS harga,
                 COALESCE(C.cost,0) AS cost,
                 H.price_document,
                 UPPER(C.no_container_2) as no_container,
                 CONCAT(E.city_code) as destination,
                 to_char(D.sailing_date, 'dd/mm/yyyy') as sailing_date,
                 JSON_AGG(DISTINCT G.sender_name_bapb) AS senders,
                 case when count(I) = 0
                     then '[]'
                     else JSON_AGG(json_build_object('id', I.bapb_sender_cost_id,
                         'sender', G.sender_name,
                         'name', I.bapb_sender_cost_name, 'price', I.price))
                 end as costs
          FROM tr_invoice A
          INNER JOIN tr_invoice_bapb B
            ON A.invoice_id = B.invoice_id
            AND B.deleted_at IS NULL
          INNER JOIN tr_bapb C
            ON B.bapb_id = C.bapb_id
            AND C.deleted_at IS NULL
          INNER JOIN ms_ship D
            ON C.ship_id = D.ship_id
          INNER JOIN ms_city E
            ON D.city_id_to = E.city_id
          LEFT JOIN tr_bapb_sender F
            ON C.bapb_id = F.bapb_id
            AND F.deleted_at IS NULL
          LEFT JOIN ms_sender G
            ON F.sender_id = G.sender_id
            AND G.deleted_at IS NULL
          LEFT JOIN tr_bapb_sender_cost I
            ON I.bapb_sender_id = F.bapb_sender_id
            AND I.price IS NOT NULL
            AND I.deleted_at IS NULL
          INNER JOIN ms_recipient H
            ON C.recipient_id = H.recipient_id
            AND H.deleted_at IS NULL
          WHERE A.deleted_at IS NULL
          AND A.invoice_id = $invoiceId
          GROUP BY A.invoice_id, A.invoice_no, C.bapb_id, C.bapb_no, C.harga, C.cost,
                   C.no_container_1, C.no_container_2,
                   E.city_code, E.city_name,
                   D.sailing_date,
                   H.recipient_id
        "
        );

        return $bapb;
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            // Handle by a closure.
            BeforeExport::class  => function (BeforeExport $event) {
                $event->writer->getProperties()->setCreator('SRSM');
            },

            // Array callable, refering to a static method.
            BeforeWriting::class => [self::class, 'beforeWriting'],

            AfterSheet::class => function (AfterSheet $event) {
                $event->getSheet()->getDelegate()->getPageSetup()
                    ->setOrientation(PageSetup::ORIENTATION_LANDSCAPE)
                    ->setPaperSize(PageSetup::PAPERSIZE_A4)
                    ->setHorizontalCentered(true)
                    ->setVerticalCentered(false);

                Sheet::macro('styleCells', function (Sheet $sheet, string $cellRange, array $style) {
                    $sheet->getDelegate()->getStyle($cellRange)->applyFromArray($style);
                    $sheet->autoSize();
                });

                $costTotal = 0;
                foreach ($this->input['bapbList'] as $bapb) {
                    foreach ($bapb->costs as $cost) {
                        $costTotal++;
                    }
                }

                $event->sheet->styleCells(
                    'A5:G' . (5 + count($this->input['bapbList']) + $costTotal + 4),
                    [
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                'color'       => ['argb' => '000000'],
                            ],
                        ],
                    ]
                );
                $event->sheet->styleCells(
                    'A5:G5',
                    [
                        'font'    => [
                            'bold' => true,
                        ],
                        'fill'    => [
                            'fillType'   => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                            'startColor' => [
                                'argb' => '25cad0',
                            ],
                        ],
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                'color'       => ['argb' => '000000'],
                            ],
                        ],
                    ]
                );
            },
        ];
    }

    public static function beforeWriting(BeforeWriting $event)
    {
        //
    }
}
