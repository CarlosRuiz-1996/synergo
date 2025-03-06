<?php

namespace App\Models\Catalogos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CtgTanques extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "ctg_tanques";
    protected $connection = 'sqlsrv_synergo';

    protected $fillable = [
      'capacidad',
      'diametro',
      'niv_seg',
      'niv_op',
      'edo',
      'fondaje',
      'capa_oper',
      'tan_dt_alta',
    ];


}
