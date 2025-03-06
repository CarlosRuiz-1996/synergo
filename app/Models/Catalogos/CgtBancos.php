<?php

namespace App\Models\Catalogos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class CgtBancos extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "cgt_bancos";
    protected $connection = 'sqlsrv_synergo';

    protected $fillable = [
        'descripcion',
        'no_secuencial',
        'saldo',
        'imprimir',
        'created_at',
        'updated_at',
    ];
}
