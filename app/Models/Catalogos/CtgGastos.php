<?php

namespace App\Models\Catalogos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CtgGastos extends Model
{
    use HasFactory;
    protected $table = "ctg_gastos";
    use SoftDeletes;
    protected $connection = 'sqlsrv_synergo';

    protected $fillable = [
        'descripcion',
    ];

}
