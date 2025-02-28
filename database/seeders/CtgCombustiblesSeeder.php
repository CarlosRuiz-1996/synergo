<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CtgCombustiblesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::connection('sqlsrv_synergo')->table('ctg_combustibles')->insert([
            [
                'nu_combustible' => 1,
                'descripcion' => 'PEMEX MAGNA',
                'costo' => 5.1656,
                'merma' => 0.04427,
                'flete' => 0.03563,
                'venta' => 7.32,
                'corta' => 'MAGNA',
                'ptos_compra' => 10,
                'ptos_venta' => 500,
                'clv_pemex' => '32011',
                'color_tq' => '65280',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nu_combustible' => 2,
                'descripcion' => 'PEMEX PREMIUM',
                'costo' => 6.1137,
                'merma' => 0.05234,
                'flete' => 0.03563,
                'venta' => 9.13,
                'corta' => 'PREMIUM',
                'ptos_compra' => 10,
                'ptos_venta' => 500,
                'clv_pemex' => '32012',
                'color_tq' => '255',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nu_combustible' => 3,
                'descripcion' => 'PEMEX DIESEL',
                'costo' => 3.3835,
                'merma' => 0,
                'flete' => 0.0277,
                'venta' => 6.27,
                'corta' => 'DIESEL',
                'ptos_compra' => 0,
                'ptos_venta' => 0,
                'clv_pemex' => '34006',
                'color_tq' => '16711680',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
