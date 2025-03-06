<?php

namespace App\Models\Catalogos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CtgConGastos extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "ctg_con_gastos";
    protected $connection = 'sqlsrv_synergo';

    protected $fillable = [
        'no_gasto',
        'concepto',
        'descripcion',
        'tipo_gasto',
        'relacion',
    ];
}
