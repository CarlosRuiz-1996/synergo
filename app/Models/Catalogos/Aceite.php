<?php

namespace App\Models\Catalogos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Aceite extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "CatAceites";
    protected $connection = 'sqlsrv_synergo';

    protected $fillable = [
        'tipo',
        'nuAceite',
        'description',
        'corta',
        'costo',
        'existencia',
        'status',
        'ptosVenta',
        'ptosCompra',
        'vtaFechaProceso'

    ];
}
