<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\View as ViewView;
use Maatwebsite\Excel\Concerns\FromView;

class ExportResumenCompras implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
        protected $data;
        protected $fechaInicio;
        protected $fechaFin;
        protected $invInicial;
    
        public function __construct(Collection $data, $fechaInicio, $fechaFin,$invInicial)
        {
            $this->data = $data;
            $this->fechaInicio = date('Y-m-d', strtotime($fechaInicio));
            $this->fechaFin = date('Y-m-d', strtotime($fechaFin));
            $this->invInicial=$invInicial;
            
            
        }
    
        public function view(): View
    {
        return view('reportes.ExcelreporteResume', [
            'datos' => $this->data,
            'fechaInicio' => $this->fechaInicio,
            'fechaFin' => $this->fechaFin,
            'invInicial' =>$this->invInicial,
        ]);
    }
}