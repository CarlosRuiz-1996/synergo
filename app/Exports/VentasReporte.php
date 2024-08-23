<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\View as ViewView;
use Maatwebsite\Excel\Concerns\FromView;

class VentasReporte implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
        protected $data;
        protected $fechaInicio;
        protected $fechaFin;
        protected $estaciones;
    
        public function __construct(Collection $data, $fechaInicio, $fechaFin,$estacion)
        {
            $this->data = $data;
            $this->fechaInicio = date('Y-m-d', strtotime($fechaInicio));
            $this->fechaFin = date('Y-m-d', strtotime($fechaFin));
            $this->estaciones = $estacion;
            
            
        }
    
        public function view(): View
    {
        return view('reportes.Excelreporte', [
            'datos' => $this->data,
            'fechaInicio' => $this->fechaInicio,
            'fechaFin' => $this->fechaFin,
            'estaciones' => $this->estaciones,
        ]);
    }
    }
