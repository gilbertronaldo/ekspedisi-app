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
 * Class ShipLangsungTagihExports
 *
 * @package App\Exports
 */
class ShipLangsungTagihExports implements FromView, WithEvents
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

        return view('ship.excel.langsung-tagih', $input);
    }

    private function getItems()
    {
        return DB::select("
            SELECT
                UPPER(CONCAT(tr_bapb.no_container_1, ' ', tr_bapb.no_container_2)) as no_container,
                tr_bapb.bapb_no,
                tr_bapb.harga AS total,
                ms_recipient.recipient_name_bapb
            FROM tr_bapb
            INNER JOIN ms_recipient
                ON tr_bapb.recipient_id = ms_recipient.recipient_id
                AND ms_recipient.deleted_at IS NULL
            WHERE tr_bapb.ship_id = $this->shipId
            AND tr_bapb.langsung_tagih IS TRUE
            GROUP BY
                tr_bapb.bapb_no,
                tr_bapb.no_container_1,
                tr_bapb.no_container_2,
                tr_bapb.harga,
                ms_recipient.recipient_name_bapb
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
                    "A8:E" . (string)(8 + $totalItems),
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
                    'A8:E8',
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
                    "B" . (9 + $totalItems) . ":C" . (9 + $totalItems),
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
