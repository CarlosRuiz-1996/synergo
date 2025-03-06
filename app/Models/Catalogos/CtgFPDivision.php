<?php

namespace App\Models\Catalogos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CtgFPDivision extends Model
{
    use HasFactory;
    protected $table = "ctg_fpdivisions";
    use SoftDeletes;
    protected $connection = 'sqlsrv_synergo';
    protected $primaryKey = 'id';

    protected $fillable = [
        'division',
        'descripcion',
    ];

  
}
