<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\View as ViewView;
use Maatwebsite\Excel\Concerns\FromView;

class ExportInvCombustible implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
        protected $data;
        protected $fechaInicio;
        protected $fechaFin;
        protected $invInicial;
        protected $ventas;
        protected $CostoPromedio;
    
        public function __construct(Collection $data)
        {
            $this->data = $data;
            
            
        }
    
        public function view(): View
    {
        return view('reportes.ExcelreporteInvCombustible', [
            'datos' => $this->data,
        ]);
    }
}
