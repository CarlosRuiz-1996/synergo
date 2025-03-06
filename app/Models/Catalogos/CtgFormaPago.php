<?php

namespace App\Models\Catalogos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CtgFormaPago extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "ctg_forma_pagos";
    protected $connection = 'sqlsrv_synergo';

    protected $fillable = [
        'descripcion',
        'consulta',
        'bnd_factura',
        'nu_copias',
        'bnd_autorizacion',
        'bnd_puntada',
    ];

  
}
