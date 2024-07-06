<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstacionesExcel extends Model
{
    use HasFactory;


    protected $table = 'EstacionesExcel';
    protected $primaryKey = 'IdEstacion';
    public $timestamps = false; // Agregar esta línea para desactivar los timestamps

    protected $fillable = [
        'estacion',
        'NumeroSistemaContable',
        'NumeroDestino',
        'FechaInicioOperaciones',
        'PermisoCRE',
        'SIIC',
        'NombreEstacion',
        'RFC',
        'DireccionFiscal',
        'AnalistaJR',
        'CorreoAnalistaJR',
        'Contador',
        'CorreoContador',
        'AnalistaCtaXPagar',
        'CorreoCXP',
        'AnalistaCtaXCobrar',
        'CorreoCXC',
        'Secretaria',
        'CorreoSCA',
        'DescargaContracargos',
    ];
}
