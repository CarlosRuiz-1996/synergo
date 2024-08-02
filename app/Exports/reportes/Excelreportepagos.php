<?php

namespace App\Exports\reportes;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\View as ViewView;
use Maatwebsite\Excel\Concerns\FromView;

class Excelreportepagos implements FromView
{
    protected $data;
    protected $fechaInicio;
    protected $fechaFin;
    protected $nombreReporte;

    public function __construct(Collection $data, $nombreReporte, $fechaInicio, $fechaFin)
    {
        $this->data = $data;
        $this->nombreReporte = $nombreReporte;
        $this->fechaInicio = $fechaInicio;
        $this->fechaFin = $fechaFin;
    }

    public function view(): View
    {
        return view('reportes.Excelreportepagos', [
            'datos' => $this->data,
            'nombreReporte' => $this->nombreReporte,
            'fechaInicio' => $this->fechaInicio,
            'fechaFin' => $this->fechaFin,
        ]);
    }
}
