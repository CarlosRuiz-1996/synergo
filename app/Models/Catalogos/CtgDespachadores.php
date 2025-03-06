<?php

namespace App\Models\Catalogos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CtgDespachadores extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "ctg_despachadores";
    protected $connection = 'sqlsrv_synergo';

    protected $fillable = [
        'nu_despachador',
        'descripcion',
        'nip',
        'nu_isla',
        'turno',
        'llavero',
        'created_at',
        'updated_at',
    ];
}
