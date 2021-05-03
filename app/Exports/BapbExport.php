<?php

namespace App\Exports;

use App\TrBapb;
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
 * @package App\Exports
 */
class BapbExport implements FromView, WithEvents
{
    private $noVoyage;

    public function __construct($noVoyage)
    {
        $this->noVoyage = preg_replace('/\s+/', '', $noVoyage);
    }

    /**
     * @return View
     */
    public function view(): View
    {
        $header = $this->getHeader($this->noVoyage);
        $input = [
            'header' => $header,
            'items' => $this->getItems($this->noVoyage)
        ];

        return view('bapb.excel.bapb', $input);
    }

    private function getHeader($noVoyage)
    {
        $get = DB::SELECT("
            SELECT UPPER(CONCAT(A.no_container_1, ' ', A.no_container_2)) as no_container, A.no_seal,
                   B.no_voyage, B.ship_name, to_char(B.sailing_date, 'dd FMMonth yyyy') as sailing_date,
                   CONCAT(C.city_code, ' - ', C.city_name) as destination,
                   COUNT(A.bapb_id) total,
                   to_char(MAX(D.entry_date), 'dd FMMonth yyyy') as last_entry
            FROM tr_bapb A
            INNER JOIN ms_ship B
             ON A.ship_id = B.ship_id
             AND B.deleted_at IS NULL
            INNER JOIN ms_city C
              ON B.city_id_to = C.city_id
              AND C.deleted_at IS NULL
            LEFT JOIN tr_bapb_sender D
              ON A.bapb_id = D.bapb_id
              AND D.deleted_at IS NULL
            WHERE A.deleted_at IS NULL
            AND B.no_voyage = '$noVoyage'
            GROUP BY no_container, A.no_seal, B.no_voyage, B.ship_name, B.sailing_date, destination
        ");

        if (empty($get)) {
            return null;
        }

        return $get[0];
    }

    private function getItems($noVoyage)
    {
        $get = DB::SELECT("
            SELECT A.bapb_no,
                   TO_CHAR(C.entry_date, 'dd FMMon yyyy') as date,
                   B.recipient_name,
                   D.sender_name,
                   SUM(E.koli) AS koli,
                   STRING_AGG(E.bapb_sender_item_name, ', ') AS bapb_sender_item_name,
                   C.kemasan,
                   C.description,
                   C.price,
                   C.dimensi AS dimensi,
                   C.berat AS berat
            FROM tr_bapb A
            INNER JOIN ms_recipient B
              ON A.recipient_id = B.recipient_id
             AND B.deleted_at IS NULL
             INNER JOIN ms_ship X
                  ON X.ship_id = A.ship_id
            INNER JOIN tr_bapb_sender C
             ON A.bapb_id = C.bapb_id
             AND C.deleted_at IS NULL
            INNER JOIN ms_sender D
             ON C.sender_id = D.sender_id
             AND D.deleted_at IS NULL
            INNER JOIN tr_bapb_sender_item E
              ON C.bapb_sender_id = E.bapb_sender_id
              AND E.deleted_at IS NULL
            WHERE A.deleted_at IS NULL
            AND X.no_voyage = '$noVoyage'
            GROUP BY A.bapb_no, C.entry_date, B.recipient_name, D.sender_name,
                     C.kemasan, C.description, C.price, C.dimensi, C.berat
            ORDER BY A.bapb_no
        ");
        return $get;
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            // Handle by a closure.
            BeforeExport::class => function (BeforeExport $event) {
                $event->writer->getProperties()->setCreator('SRSM');
            },

            // Array callable, refering to a static method.
            BeforeWriting::class => [self::class, 'beforeWriting'],

            AfterSheet::class => function (AfterSheet $event) {
                $event->getSheet()->getDelegate()->getPageSetup()
                    ->setOrientation(PageSetup::ORIENTATION_LANDSCAPE)
                    ->setPaperSize(PageSetup::PAPERSIZE_A4)
                    ->setHorizontalCentered(TRUE)
                    ->setVerticalCentered(FALSE);

                Sheet::macro('styleCells', function (Sheet $sheet, string $cellRange, array $style) {
                    $sheet->getDelegate()->getStyle($cellRange)->applyFromArray($style);
                    $sheet->autoSize();
                });

                $event->sheet->styleCells(
                    'A8:I100',
                    [
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                'color' => ['argb' => '000000'],
                            ],
                        ]
                    ]
                );
                $event->sheet->styleCells(
                    'A8:I8',
                    [
                        'font' => [
                            'bold' => true,
                        ],
                        'fill' => [
                            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                            'startColor' => [
                                'argb' => '25cad0',
                            ],
                        ],
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                'color' => ['argb' => '000000'],
                            ],
                        ]
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
