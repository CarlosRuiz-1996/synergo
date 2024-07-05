<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromView;

class ExportVentasConsignas implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $data;
    protected $fechaInicio;
    protected $fechaFin;

    public function __construct(Collection $data, $fechaInicio, $fechaFin)
    {
        $this->data = $data;
        $this->fechaInicio = date('Y-m-d', strtotime($fechaInicio));
        $this->fechaFin = date('Y-m-d', strtotime($fechaFin));
        
        
    }

    public function view(): View
{
    return view('reportes.ExcelreporteVentasConsiga', [
                          
        'datos' => $this->data,
        'fechaInicio' => $this->fechaInicio,
        'fechaFin' => $this->fechaFin,
    ]);
}
}
