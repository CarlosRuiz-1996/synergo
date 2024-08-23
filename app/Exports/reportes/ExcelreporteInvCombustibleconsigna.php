<?php

namespace App\Exports\reportes;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\View as ViewView;
use Maatwebsite\Excel\Concerns\FromView;

class ExcelreporteInvCombustibleconsigna implements FromView
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
        protected $valorestacionnombre;
    
        public function __construct(Collection $data,$valorestacionnombre)
        {
            $this->data = $data;
            $this->valorestacionnombre = $valorestacionnombre;
            
            
        }
    
        public function view(): View
    {
        return view('reportes.ExcelreporteInvCombustibleconsigna', [
            'datos' => $this->data,
            'estaciones' => $this->valorestacionnombre,
        ]);
    }
}