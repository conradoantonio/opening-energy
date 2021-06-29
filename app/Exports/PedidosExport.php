<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\AfterSheet;

class PedidosExport implements FromArray, WithTitle, ShouldAutoSize, WithEvents 
{
	protected $rows;
    protected $titulos;
    protected $encabezados;

	public function __construct(array $rows, array $titulos, array $encabezados)
    {
        $this->rows        = $rows;
        $this->titulos     = $titulos;
        $this->encabezados = $encabezados;
    }

    public function registerEvents(): array
    {	
    	return [
            AfterSheet::class => function (AfterSheet $event) {
            	$event->sheet->getStyle('A1')->applyFromArray([
                    'font' => [
                        'bold' => true
                    ]
                ]);

                foreach ($this->titulos as $value) {
                    $event->sheet->getStyle('A'.$value.':F'.$value)->applyFromArray([
                        'font' => [
                            'bold' => true
                        ]
                    ]);
                }
            	
                foreach ($this->encabezados as $value) {
                    $event->sheet->getStyle('A'.$value.':AD'.$value)->applyFromArray([
                        'font' => [
                            'bold' => true
                        ],
                        'alignment' => [
                            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER
                        ]
                    ]);
                    $event->sheet->getStyle('E'.$value)->applyFromArray([
                        'font' => [
                            'bold' => true
                        ]
                    ]);
                }

                foreach ($this->rows as $key=>$value) {
                    if($key >= 3) {
                        $event->sheet->getStyle('J'.($key+1))->applyFromArray([
                            'font' => [
                                'bold' => false
                            ],
                            'alignment' => [
                                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT
                            ]
                        ]);
                    }                    
                }

                foreach ($this->rows as $key=>$value) {
                    if($key >= 3) {
                        $event->sheet->getStyle('L'.($key+1))->applyFromArray([
                            'font' => [
                                'bold' => false
                            ],
                            'alignment' => [
                                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT
                            ]
                        ]);
                    }                    
                }

                foreach ($this->rows as $key=>$value) {
                    if($key >= 3) {
                        $event->sheet->getStyle('M'.($key+1))->applyFromArray([
                            'font' => [
                                'bold' => false
                            ],
                            'alignment' => [
                                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER
                            ]
                        ]);
                    }                    
                }

                foreach ($this->rows as $key=>$value) {
                    if($key >= 3) {
                        $event->sheet->getStyle('T'.($key+1))->applyFromArray([
                            'font' => [
                                'bold' => false
                            ],
                            'alignment' => [
                                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT
                            ]
                        ]);
                    }                    
                }

                foreach ($this->rows as $key=>$value) {
                    if($key >= 3) {
                        $event->sheet->getStyle('U'.($key+1))->applyFromArray([
                            'font' => [
                                'bold' => false
                            ],
                            'alignment' => [
                                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT
                            ]
                        ]);
                    }                    
                }

                foreach ($this->rows as $key=>$value) {
                    if($key >= 3) {
                        $event->sheet->getStyle('W'.($key+1))->applyFromArray([
                            'font' => [
                                'bold' => false
                            ],
                            'alignment' => [
                                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT
                            ]
                        ]);
                    }                    
                }

                foreach ($this->rows as $key=>$value) {
                    if($key >= 3) {
                        $event->sheet->getStyle('X'.($key+1))->applyFromArray([
                            'font' => [
                                'bold' => false
                            ],
                            'alignment' => [
                                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT
                            ]
                        ]);
                    }                    
                }
            }
        ];
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function array(): array
    {
        return $this->rows;
    }

    public function title(): string
    {
        return 'Productos pedidos';
    }
}
