<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CtgFormaPagoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $formas_pago = [
            [
                'nu_forma_pago' => 0,
                'descripcion' => 'MONEDERO',
                'consulta' => 'Monedero',
                'bnd_factura' => true,
                'nu_copias' => 2,
                'bnd_autorizacion' => false,
                'bnd_puntada' => false
            ],
            [
                'nu_forma_pago' => 1,
                'descripcion' => 'Efectivo',
                'consulta' => 'Efectivo',
                'bnd_factura' => true,
                'nu_copias' => 1,
                'bnd_autorizacion' => false,
                'bnd_puntada' => true
            ],
            [
                'nu_forma_pago' => 2,
                'descripcion' => 'VALES',
                'consulta' => 'Vales',
                'bnd_factura' => false,
                'nu_copias' => 1,
                'bnd_autorizacion' => false,
                'bnd_puntada' => true
            ],
            [
                'nu_forma_pago' => 3,
                'descripcion' => 'AMERICAN EXPRESS',
                'consulta' => 'Amex',
                'bnd_factura' => true,
                'nu_copias' => 2,
                'bnd_autorizacion' => true,
                'bnd_puntada' => true
            ],
            [
                'nu_forma_pago' => 4,
                'descripcion' => 'GAS CARD AMEX',
                'consulta' => 'GasCard',
                'bnd_factura' => false,
                'nu_copias' => 2,
                'bnd_autorizacion' => true,
                'bnd_puntada' => true
            ],
            [
                'nu_forma_pago' => 5,
                'descripcion' => 'VISA/MASTERCARD',
                'consulta' => 'Visa/MC',
                'bnd_factura' => true,
                'nu_copias' => 2,
                'bnd_autorizacion' => true,
                'bnd_puntada' => true
            ],
            [
                'nu_forma_pago' => 6,
                'descripcion' => 'VALE ELECTRONICO',
                'consulta' => 'Vale/Elec',
                'bnd_factura' => false,
                'nu_copias' => 2,
                'bnd_autorizacion' => true,
                'bnd_puntada' => true
            ],
            [
                'nu_forma_pago' => 7,
                'descripcion' => 'CREDITO ES',
                'consulta' => 'Credito ES',
                'bnd_factura' => true,
                'nu_copias' => 2,
                'bnd_autorizacion' => false,
                'bnd_puntada' => false
            ]
        ];

        foreach ($formas_pago as $forma_pago) {
            DB::connection('sqlsrv_synergo')->table('ctg_forma_pagos')->insert($forma_pago);
        }
    }
}
