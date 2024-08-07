<?php

namespace App\Exports\reportes;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExcelreporteFacturascargas implements FromCollection, WithHeadings
{
    protected $fallidos;
    protected $aceptados;

    public function __construct($fallidos, $aceptados)
    {
        $this->fallidos = $fallidos;
        $this->aceptados = $aceptados;
    }

    public function collection()
    {
        // Combina fallidos y aceptados en una colección
        $data = collect();

        if ($this->fallidos->isNotEmpty()) {
            foreach ($this->fallidos as $item) {
                $data->push([
                    'Folio' => $item['folio'],
                    'Concepto' => $item['descripcion'],
                    'Emisor' => $item['nombre_emisor'],
                    'Mensaje' => 'Factura con este folio ya existe, y fue omitida.',
                    'Estado' => 'Rechazado'
                ]);
            }
        }

        if ($this->aceptados->isNotEmpty()) {
            foreach ($this->aceptados as $item) {
                $data->push([
                    'Folio' => $item['folio'],
                    'Concepto' => $item['descripcion'],
                    'Emisor' => $item['nombre_emisor'],
                    'Mensaje' => 'Factura registrada correctamente',
                    'Estado' => 'Aceptado'
                ]);
            }
        }

        return $data;
    }

    public function headings(): array
    {
        return [
            'Folio',
            'Concepto',
            'Emisor',
            'Mensaje',
            'Estado'
        ];
    }
}
