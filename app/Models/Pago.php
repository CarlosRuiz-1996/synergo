<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    use HasFactory;
    protected $table = 'hPago';

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cve_expediente', 'clave_expediente');
    }

    public function conceptoDePago()
    {
        return $this->belongsTo(ConceptoDePago::class, 'id_dcConceptoDePago', 'id_dcConceptoDePago');
    }

   


   

    public function actividadExtra()
    {
        return $this->belongsTo(ActividadExtra::class, 'acttmp', 'idactividades_extras');
    }
}
