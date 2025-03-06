<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CatBancosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::connection('sqlsrv_synergo')->table('cgt_bancos')->insert([
            [
                'descripcion' => 'BANCOMER',
                'no_secuencial' => 137,
                'saldo' => 0,
                'imprimir' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'descripcion' => 'AMERICAN EXPRESS',
                'no_secuencial' => 1,
                'saldo' => 1,
                'imprimir' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'descripcion' => 'VISA MASTERCARD',
                'no_secuencial' => 1,
                'saldo' => 1,
                'imprimir' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'descripcion' => 'FONDO DISPENSARIOS',
                'no_secuencial' => 0,
                'saldo' => 0,
                'imprimir' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
