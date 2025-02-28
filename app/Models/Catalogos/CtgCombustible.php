<?php

namespace App\Models\Catalogos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CtgCombustible extends Model
{
    use HasFactory;


    protected $table = "ctg_combustibles";
    protected $connection = 'sqlsrv_synergo';

    protected $fillable = [
        'descripcion',
        'costo',
        'merma',
        'flete',
        'venta',
        'corta',
        'ptos_compra',
        'ptos_venta',
        'clv_pemex',
        'color_tq',
        'created_at',
        'updated_at',
    ];
}
