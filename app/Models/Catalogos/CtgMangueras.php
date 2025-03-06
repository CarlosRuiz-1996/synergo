<?php

namespace App\Models\Catalogos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CtgMangueras extends Model
{
    use HasFactory;
    protected $table = "ctg_mangueras";
    use SoftDeletes;
    protected $connection = 'sqlsrv_synergo';

    protected $fillable = [
        'nu_isla',
        'nu_combustible',
        'nu_pos_carga',
        'lec_ini',
        'estado',
        'nu_cliente',
        'nu_tarjeta',
        'bnd_miles',
        'nu_antena',
        'nu_pistola',
        'man_dt_alta',
    ];
    
}
