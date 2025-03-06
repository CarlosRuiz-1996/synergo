<?php

namespace App\Models\Catalogos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CtgTablas extends Model
{
    use HasFactory;
    protected $table = "ctg_tablas";
    use SoftDeletes;
    protected $connection = 'sqlsrv_synergo';

    protected $fillable = [
        'nombre',
        'bnd_catalogo',
        'n_padre',
        'fecha',
    ];    
}
