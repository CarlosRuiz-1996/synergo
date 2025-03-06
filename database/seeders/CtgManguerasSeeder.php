<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CtgManguerasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mangueras = [
            ['nu_manguera' => 1, 'nu_isla' => 1, 'nu_combustible' => 2, 'nu_pos_carga' => 1, 'lec_ini' => 11, 'estado' => null, 'nu_cliente' => 0, 'nu_tarjeta' => 0, 'bnd_miles' => 1, 'nu_antena' => 86, 'nu_pistola' => 00000000, 'man_dt_alta' => '2007-01-01 00:00:00'],
            ['nu_manguera' => 2, 'nu_isla' => 1, 'nu_combustible' => 1, 'nu_pos_carga' => 1, 'lec_ini' => 11, 'estado' => null, 'nu_cliente' => 0, 'nu_tarjeta' => 0, 'bnd_miles' => 1, 'nu_antena' => 86, 'nu_pistola' => 00000000, 'man_dt_alta' => '2007-01-01 00:00:00'],
            ['nu_manguera' => 3, 'nu_isla' => 1, 'nu_combustible' => 2, 'nu_pos_carga' => 2, 'lec_ini' => 11, 'estado' => null, 'nu_cliente' => 0, 'nu_tarjeta' => 0, 'bnd_miles' => 1, 'nu_antena' => 86, 'nu_pistola' => 00000000, 'man_dt_alta' => '2007-01-01 00:00:00'],
            ['nu_manguera' => 4, 'nu_isla' => 1, 'nu_combustible' => 1, 'nu_pos_carga' => 2, 'lec_ini' => 11, 'estado' => null, 'nu_cliente' => 0, 'nu_tarjeta' => 0, 'bnd_miles' => 1, 'nu_antena' => 86, 'nu_pistola' => 00000000, 'man_dt_alta' => '2007-01-01 00:00:00'],
            ['nu_manguera' => 5, 'nu_isla' => 1, 'nu_combustible' => 2, 'nu_pos_carga' => 3, 'lec_ini' => 11, 'estado' => null, 'nu_cliente' => 0, 'nu_tarjeta' => 0, 'bnd_miles' => 1, 'nu_antena' => 86, 'nu_pistola' => 00000000, 'man_dt_alta' => '2007-01-01 00:00:00'],
            ['nu_manguera' => 6, 'nu_isla' => 1, 'nu_combustible' => 1, 'nu_pos_carga' => 3, 'lec_ini' => 11, 'estado' => null, 'nu_cliente' => 0, 'nu_tarjeta' => 0, 'bnd_miles' => 1, 'nu_antena' => 86, 'nu_pistola' => 00000000, 'man_dt_alta' => '2007-01-01 00:00:00'],
            ['nu_manguera' => 7, 'nu_isla' => 1, 'nu_combustible' => 2, 'nu_pos_carga' => 4, 'lec_ini' => 11, 'estado' => null, 'nu_cliente' => 0, 'nu_tarjeta' => 0, 'bnd_miles' => 1, 'nu_antena' => 86, 'nu_pistola' => 00000000, 'man_dt_alta' => '2007-01-01 00:00:00'],
            ['nu_manguera' => 8, 'nu_isla' => 1, 'nu_combustible' => 1, 'nu_pos_carga' => 4, 'lec_ini' => 11, 'estado' => null, 'nu_cliente' => 0, 'nu_tarjeta' => 0, 'bnd_miles' => 1, 'nu_antena' => 86, 'nu_pistola' => 00000000, 'man_dt_alta' => '2007-01-01 00:00:00'],
            ['nu_manguera' => 9, 'nu_isla' => 1, 'nu_combustible' => 2, 'nu_pos_carga' => 5, 'lec_ini' => 11, 'estado' => null, 'nu_cliente' => 0, 'nu_tarjeta' => 0, 'bnd_miles' => 1, 'nu_antena' => 86, 'nu_pistola' => 00000000, 'man_dt_alta' => '2007-01-01 00:00:00'],
            ['nu_manguera' => 10, 'nu_isla' => 1, 'nu_combustible' => 1, 'nu_pos_carga' => 5, 'lec_ini' => 11, 'estado' => null, 'nu_cliente' => 0, 'nu_tarjeta' => 0, 'bnd_miles' => 1, 'nu_antena' => 86, 'nu_pistola' => 00000000, 'man_dt_alta' => '2007-01-01 00:00:00'],
            ['nu_manguera' => 11, 'nu_isla' => 1, 'nu_combustible' => 2, 'nu_pos_carga' => 6, 'lec_ini' => 11, 'estado' => null, 'nu_cliente' => 0, 'nu_tarjeta' => 0, 'bnd_miles' => 1, 'nu_antena' => 86, 'nu_pistola' => 00000000, 'man_dt_alta' => '2007-01-01 00:00:00'],
            ['nu_manguera' => 12, 'nu_isla' => 1, 'nu_combustible' => 1, 'nu_pos_carga' => 6, 'lec_ini' => 11, 'estado' => null, 'nu_cliente' => 0, 'nu_tarjeta' => 0, 'bnd_miles' => 1, 'nu_antena' => 86, 'nu_pistola' => 00000000, 'man_dt_alta' => '2007-01-01 00:00:00'],
            ['nu_manguera' => 13, 'nu_isla' => 1, 'nu_combustible' => 2, 'nu_pos_carga' => 7, 'lec_ini' => 11, 'estado' => null, 'nu_cliente' => 0, 'nu_tarjeta' => 0, 'bnd_miles' => 1, 'nu_antena' => 86, 'nu_pistola' => 00000000, 'man_dt_alta' => '2007-01-01 00:00:00'],
            ['nu_manguera' => 14, 'nu_isla' => 1, 'nu_combustible' => 1, 'nu_pos_carga' => 7, 'lec_ini' => 11, 'estado' => null, 'nu_cliente' => 0, 'nu_tarjeta' => 0, 'bnd_miles' => 1, 'nu_antena' => 86, 'nu_pistola' => 00000000, 'man_dt_alta' => '2007-01-01 00:00:00'],
            ['nu_manguera' => 15, 'nu_isla' => 1, 'nu_combustible' => 3, 'nu_pos_carga' => 7, 'lec_ini' => 11, 'estado' => null, 'nu_cliente' => 0, 'nu_tarjeta' => 0, 'bnd_miles' => 1, 'nu_antena' => 86, 'nu_pistola' => 00000000, 'man_dt_alta' => '2007-01-01 00:00:00'],
            ['nu_manguera' => 16, 'nu_isla' => 1, 'nu_combustible' => 2, 'nu_pos_carga' => 8, 'lec_ini' => 11, 'estado' => null, 'nu_cliente' => 0, 'nu_tarjeta' => 0, 'bnd_miles' => 1, 'nu_antena' => 86, 'nu_pistola' => 00000000, 'man_dt_alta' => '2007-01-01 00:00:00'],
            ['nu_manguera' => 17, 'nu_isla' => 1, 'nu_combustible' => 1, 'nu_pos_carga' => 8, 'lec_ini' => 11, 'estado' => null, 'nu_cliente' => 0, 'nu_tarjeta' => 0, 'bnd_miles' => 1, 'nu_antena' => 86, 'nu_pistola' => 00000000, 'man_dt_alta' => '2007-01-01 00:00:00'],
            ['nu_manguera' => 18, 'nu_isla' => 1, 'nu_combustible' => 3, 'nu_pos_carga' => 8, 'lec_ini' => 11, 'estado' => null, 'nu_cliente' => 0, 'nu_tarjeta' => 0, 'bnd_miles' => 1, 'nu_antena' => 86, 'nu_pistola' => 00000000, 'man_dt_alta' => '2007-01-01 00:00:00'],
        ];

        foreach ($mangueras as $manguera) {
            DB::connection('sqlsrv_synergo')->table('ctg_mangueras')->insert($manguera);
        }
    }
}
