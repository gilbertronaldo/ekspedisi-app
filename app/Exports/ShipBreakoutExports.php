<?php


namespace App\Exports;

use App\MsShip;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\BeforeWriting;
use Maatwebsite\Excel\Sheet;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;

/**
 * Class ShipBreakoutExports
 *
 * @package App\Exports
 */
class ShipBreakoutExports implements FromView, WithEvents
{
    private $shipId;
    private $items;

    public function __construct($shipId)
    {
        $this->shipId = $shipId;

        $this->items = $this->getItems();
    }

    public function view(): View
    {
        $ship = MsShip::findOrFail($this->shipId);

        foreach ($this->items as $item) {
            if ($item->berat) {
                $item->total = $item->price_ton * $item->berat;
            } else {
                $item->total = $item->price_meter * $item->dimensi;
            }
        }
        $total = collect($this->items)->reduce(
            function ($i, $j) {
                return $i + $j->total;
            }
        );
        $input = [
            'header' => $ship,
            'items'  => $this->items,
            'total'  => $total,
        ];

        return view('ship.excel.breakout', $input);
    }

    private function getItems()
    {
        return DB::select("
            SELECT
                ms_ship.no_voyage,
                UPPER(CONCAT(tr_bapb.no_container_1, ' ', tr_bapb.no_container_2)) as no_container,
                tr_bapb.bapb_no,
                tr_bapb.harga AS total,
                ms_recipient.recipient_name_bapb,
                ms_sender.sender_name_bapb,
                tr_bapb_sender_item.koli,
                round(CAST(tr_bapb_sender_item.panjang *  tr_bapb_sender_item.lebar *  tr_bapb_sender_item.tinggi * tr_bapb_sender_item.koli AS numeric) / 1000000, 3) AS dimensi,
                tr_bapb_sender_item.berat,
                tr_bapb_sender_item.price,
                   CASE WHEN tr_bapb.tagih_di = 'sender'
                       THEN   ms_sender.price_meter
                       ELSE ms_recipient.price_meter
                    END AS price_meter,
                  CASE WHEN tr_bapb.tagih_di = 'sender'
                       THEN   ms_sender.price_ton
                       ELSE ms_recipient.price_ton
                    END AS price_ton
            FROM tr_bapb
            INNER JOIN ms_ship
                ON tr_bapb.ship_id = ms_ship.ship_id
                AND ms_ship.deleted_at IS NULL
            INNER JOIN ms_recipient
                ON tr_bapb.recipient_id = ms_recipient.recipient_id
                AND ms_recipient.deleted_at IS NULL
            INNER JOIN tr_bapb_sender
                ON tr_bapb.bapb_id = tr_bapb_sender.bapb_id
                AND tr_bapb_sender.deleted_at IS NULL
            INNER JOIN ms_sender
                ON tr_bapb_sender.sender_id = ms_sender.sender_id
                AND ms_sender.deleted_at IS NULL
            INNER JOIN tr_bapb_sender_item
                ON tr_bapb_sender.bapb_sender_id = tr_bapb_sender_item.bapb_sender_id
                AND tr_bapb_sender_item.deleted_at IS NULL
            WHERE tr_bapb.ship_id = $this->shipId
            AND tr_bapb.tagih_jkt IS TRUE
            ORDER BY  tr_bapb.bapb_no;
        ");
    }

    public function registerEvents(): array
    {
        $totalItems = count($this->items);
        return [
            // Handle by a closure.
            BeforeExport::class  => function (BeforeExport $event) {
                $event->writer->getProperties()->setCreator('SRSM');
            },

            // Array callable, refering to a static method.
            BeforeWriting::class => [self::class, 'beforeWriting'],

            AfterSheet::class => function (AfterSheet $event) use ($totalItems) {
                $event->getSheet()->getDelegate()->getPageSetup()
                    ->setOrientation(PageSetup::ORIENTATION_LANDSCAPE)
                    ->setPaperSize(PageSetup::PAPERSIZE_A4)
                    ->setHorizontalCentered(true)
                    ->setVerticalCentered(false);

                Sheet::macro('styleCells', function (Sheet $sheet, string $cellRange, array $style) {
                    $sheet->getDelegate()->getStyle($cellRange)->applyFromArray($style);
                    $sheet->autoSize();
                });

                $event->sheet->styleCells(
                    "A8:I" . (string)(8 + $totalItems),
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
                    'A8:I8',
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

                $event->sheet->styleCells(
                    "A" . (9 + $totalItems) . ":I" . (9 + $totalItems),
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
