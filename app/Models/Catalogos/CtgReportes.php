<?php

namespace App\Models\Catalogos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CtgReportes extends Model
{
    use HasFactory;
    protected $table = "ctg_reportes";
    use SoftDeletes;
    protected $connection = 'sqlsrv_synergo';

    protected $fillable = [
        'titulo',
        'consulta',
        'nivel',
    ];
   
     
}
