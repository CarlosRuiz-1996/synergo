<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CtgGastosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $gastos = [
            ['nu_gasto' => 1, 'descripcion' => 'FIJOS'],
            ['nu_gasto' => 2, 'descripcion' => 'VARIABLES'],
            ['nu_gasto' => 3, 'descripcion' => 'MTTO Y CONSERV.'],
            ['nu_gasto' => 4, 'descripcion' => 'MTTO DE EQUIPO'],
            ['nu_gasto' => 5, 'descripcion' => 'GAS GERENTE'],
            ['nu_gasto' => 6, 'descripcion' => 'VALES GERENTE'],
            ['nu_gasto' => 7, 'descripcion' => 'JARRAS'],
            ['nu_gasto' => 8, 'descripcion' => 'GAS FAMILIA'],
            ['nu_gasto' => 9, 'descripcion' => 'GASTOS DE PISO'],
        ];

        foreach ($gastos as $gasto) {
            DB::connection('sqlsrv_synergo')->table('ctg_gastos')->insert($gasto);
        }
    }
}
