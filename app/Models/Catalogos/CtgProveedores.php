<?php

namespace App\Models\Catalogos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CtgProveedores extends Model
{
    use HasFactory;

    protected $table = "ctg_proveedores";
    protected $connection = 'sqlsrv_synergo';

    protected $fillable = [
        'nombre',
        'rfc',
        'calle',
        'colonia',
        'ciudad',
        'edo',
        'cp',
        'tel',
        'fax',
        'contacto',
        'credito',
        'created_at',
        'updated_at',
    ];
}
