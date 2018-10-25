<?php

namespace App\Exports;

use App\TrBapb;
use Illuminate\Contracts\View\View;
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
    /**
     * @return View
     */
    public function view(): View
    {
        return view('bapb.excel.bapb', [
            'bapbList' => TrBapb::with('senders.items')
                ->with('recipient')
                ->with('ship')
                ->get()
        ]);
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            // Handle by a closure.
            BeforeExport::class => function (BeforeExport $event) {
                $event->writer->getProperties()->setCreator('Patrick');
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
