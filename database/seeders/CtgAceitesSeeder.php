<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CtgAceitesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Schema::table('CatAceites', function (Blueprint $table) {
        //     $table->decimal('costo', 10, 5)->change(); // Ajusta la precisión según sea necesario
        // });
        $productos = [


            [
                'tipo' => 'Ac',
                'description' => 'VERDE SF/CC',
                'corta' => 'VERDE',
                'costo' => 35.9583,
                'existencia' => 1,
                'status' => 1,
                'ptosVenta' => 1,
                'ptosCompra' => 1,
                'vtaFechaProceso' => 0,
            ],
            [
                'tipo' => 'Ac',
                
                'description' => 'AZULCF/CF-2SUP',
                'corta' => 'AZUL',
                'costo' => 36.55,
                'existencia' => 107,
                'status' => 1,
                'ptosVenta' => 1,
                'ptosCompra' => 1,
                'vtaFechaProceso' => 0,
            ],
            [
                'tipo' => 'Ac',
                'description' => 'PEMEX TRANSMISOL',
                'corta' => 'TRANS',
                'costo' => 35.9167,
                'existencia' => 176,
                'status' => 1,
                'ptosVenta' => 1,
                'ptosCompra' => 1,
                'vtaFechaProceso' => 0,
            ],
            [
                'tipo' => 'Ac',
                'description' => 'SJ SAE 15W-40',
                'corta' => 'MULSJ',
                'costo' => 39.3833,
                'existencia' => 7,
                'status' => 1,
                'ptosVenta' => 1,
                'ptosCompra' => 1,
                'vtaFechaProceso' => 0,
            ],
            [
                'tipo' => 'Ac',
                'description' => 'AZGAR',
                'corta' => 'AZGAR',
                'costo' => 185.6417,
                'existencia' => 0,
                'status' => 1,
                'ptosVenta' => 1,
                'ptosCompra' => 1,
                'vtaFechaProceso' => 0,
            ],
            [
                'tipo' => 'Ac',
                'description' => 'AKRON SPITZENSN SAE 5W40',
                'corta' => 'AKSYN',
                'costo' => 96.4583,
                'existencia' => 32,
                'status' => 1,
                'ptosVenta' => 1,
                'ptosCompra' => 1,
                'vtaFechaProceso' => 0,
            ],
            [
                'tipo' => 'Ac',
                'description' => 'PROMOCION 4 RESISTENCE MAS UN',
                'corta' => 'PRRES',
                'costo' => 188.3968,
                'existencia' => 3,
                'status' => 1,
                'ptosVenta' => 1,
                'ptosCompra' => 1,
                'vtaFechaProceso' => 0,
            ],
            [
                'tipo' => 'Ac',
                'description' => 'AKRON PREMIUM SM SAE 15W40',
                'corta' => 'AKPRE',
                'costo' => 43.6583,
                'existencia' => 186,
                'status' => 1,
                'ptosVenta' => 1,
                'ptosCompra' => 1,
                'vtaFechaProceso' => 0,
            ],
            [
                'tipo' => 'Ac',
                'description' => 'AKRON ATF III',
                'corta' => 'AKATF',
                'costo' => 38.5333,
                'existencia' => 0,
                'status' => 1,
                'ptosVenta' => 1,
                'ptosCompra' => 1,
                'vtaFechaProceso' => 0,
            ],
            [
                'tipo' => 'Ac',
                'description' => 'AKRON EXTRAFLEET SAE 40',
                'corta' => 'AKSUP',
                'costo' => 35.8583,
                'existencia' => 0,
                'status' => 1,
                'ptosVenta' => 1,
                'ptosCompra' => 1,
                'vtaFechaProceso' => 0,
            ],
            [
                'tipo' => 'Ac',
                'description' => 'AKRON RESISTANCE SL SAE 25W50',
                'corta' => 'AKRES',
                'costo' => 40.4167,
                'existencia' => 0,
                'status' => 1,
                'ptosVenta' => 1,
                'ptosCompra' => 1,
                'vtaFechaProceso' => 0,
            ],
            [
                'tipo' => 'Ac',
                'description' => 'AKRON FORCESAE 15W40',
                'corta' => 'AKFOR',
                'costo' => 56.1,
                'existencia' => 0,
                'status' => 1,
                'ptosVenta' => 1,
                'ptosCompra' => 1,
                'vtaFechaProceso' => 0,
            ],
            [
                'tipo' => 'Ac',
                'description' => 'AKRON SAFETY SL SAE 20W40',
                'corta' => 'AKSAF',
                'costo' => 33.75,
                'existencia' => 0,
                'status' => 1,
                'ptosVenta' => 1,
                'ptosCompra' => 1,
                'vtaFechaProceso' => 0,
            ],
            [
                'tipo' => 'Ac',
                'description' => 'AKRON DURABILITY SL SAE 15W40',
                'corta' => 'AKDUR',
                'costo' => 33.75,
            
                'existencia' => 0,
                'status' => 1,
                'ptosVenta' => 1,
                'ptosCompra' => 1,
                'vtaFechaProceso' => 0,
            ],
            [
                'tipo' => 'Ac',
                
                'description' => 'AKRON LIMPIA PARABRISAS',
                'corta' => 'AKLP',
                'costo' => 15.7833,
                'existencia' => 341,
                'status' => 1,
                'ptosVenta' => 1,
                'ptosCompra' => 1,
                'vtaFechaProceso' => 0,
            ],
            [
                'tipo' => 'Ac',
                'description' => 'AKRON INTENSE SJ/CF SAE 40',
                'corta' => 'AKINT',
                'costo' => 39.7833,
                'existencia' => 261,
                'status' => 1,
                'ptosVenta' => 1,
                'ptosCompra' => 1,
                'vtaFechaProceso' => 0,
            ],
            [
                'tipo' => 'Ac',
                'description' => 'KIT DE CAR COSMETIC',
                'corta' => 'KITCA',
                'costo' => 73.8,
                'existencia' => 0,
                'status' => 1,
                'ptosVenta' => 1,
                'ptosCompra' => 1,
                'vtaFechaProceso' => 0,
            ],
            [
                'tipo' => 'Ot',
                'description' => 'AKON INFLALLANTAS (340GS)',
                'corta' => 'AKINF',
                'costo' => 34.8083,
                'existencia' => 0,
                'status' => 1,
                'ptosVenta' => 1,
                'ptosCompra' => 1,
                'vtaFechaProceso' => 0,
            ],
            [
                'tipo' => 'Ac',
                'description' => 'AKRON PREMIUM SM (TAMBO)',
                'corta' => 'TA208',
                'costo' => 30.649,
                'existencia' => 0,
                'status' => 1,
                'ptosVenta' => 1,
                'ptosCompra' => 1,
                'vtaFechaProceso' => 0,
            ],
            [
                'tipo' => 'Ac',
                'description' => 'AKRON ANTICONGELANTE (TAMBO)',
                'corta' => 'TA209',
                'costo' => 10.93,
                'existencia' => 0,
                'status' => 1,
                'ptosVenta' => 1,
                'ptosCompra' => 1,
                'vtaFechaProceso' => 0,
            ],
            [
                'tipo' => 'Ac',
                'description' => 'AKRON ANTICONGELANTE LITRO',
                'corta' => 'AKANT',
                'costo' => 22.3333,
                'existencia' => 0,
                'status' => 1,
                'ptosVenta' => 1,
                'ptosCompra' => 1,
                'vtaFechaProceso' => 0,
            ],
            [
                'tipo' => 'Ac',
                'description' => 'PROMOCION 4 RESISTENCE MAS UN',
                'corta' => 'PRRES',
                'costo' => 188.3968,
                'existencia' => 0,
                'status' => 1,
                'ptosVenta' => 1,
                'ptosCompra' => 1,
                'vtaFechaProceso' => null,
            ],
               [
                'tipo' => 'Ac',
                'description' => 'AKRON SAFETY SL SAE 20W40',
                'corta' => 'AKSAF',
                'costo' => 33.75,
                'existencia' => 0,
                'status' => 1,
                'ptosVenta' => 1,
                'ptosCompra' => 1,
                'vtaFechaProceso' => 0
            ],
            [
                'tipo' => 'Ac',
                'description' => 'AKRON DURABILITY SL SAE 15W40',
                'corta' => 'AKDUR',
                'costo' => 33.75,
                'existencia' => 0,
                'status' => 1,
                'ptosVenta' => 1,
                'ptosCompra' => 1,
                'vtaFechaProceso' => 0
            ],
            [
                'tipo' => 'Ac',
                'description' => 'AKRON LIMPIA PARABRISAS',
                'corta' => 'AKLP',
                'costo' => 15.7833,
                'existencia' => 341,
                'status' => 1,
                'ptosVenta' => 1,
                'ptosCompra' => 1,
                'vtaFechaProceso' => 0
            ],
            [
                'tipo' => 'Ac',
                'description' => 'AKRON INTENSE SJ/CF SAE 40',
                'corta' => 'AKINT',
                'costo' => 39.7833,
                'existencia' => 261,
                'status' => 1,
                'ptosVenta' => 1,
                'ptosCompra' => 1,
                'vtaFechaProceso' => 0
            ],
            [
                'tipo' => 'Ac',
                'description' => 'KIT DE CAR COSMETIC',
                'corta' => 'KITCA',
                'costo' => 73.8,
                'existencia' => 0,
                'status' => 1,
                'ptosVenta' => 1,
                'ptosCompra' => 1,
                'vtaFechaProceso' => 0
            ],
            [
                'tipo' => 'Ot',
                'description' => 'RADIADOR 350 ML',
                'corta' => 'RADIA',
                'costo' => 16,
                'existencia' => 981,
                'status' => 1,
                'ptosVenta' => 1,
                'ptosCompra' => 1,
                'vtaFechaProceso' => 0
            ],
            [
                'tipo' => 'Ot',
                'description' => 'LIQUIDO P/ BATERIA 500 ML',
                'corta' => 'AGUAB',
                'costo' => 5.2,
                'existencia' => 687,
                'status' => 1,
                'ptosVenta' => 1,
                'ptosCompra' => 1,
                'vtaFechaProceso' => 0
            ],
            [
                'tipo' => 'Ot',
                'description' => 'COOLANT 1L',
                'corta' => 'COOLA',
                'costo' => 25,
                'existencia' => 525,
                'status' => 1,
                'ptosVenta' => 1,
                'ptosCompra' => 1,
                'vtaFechaProceso' => 0
            ],
            [
                'tipo' => 'Ot',
                'description' => 'NAUTICO TCW-W SUPER BIA 950 ML',
                'corta' => 'NAUT1',
                'costo' => 51,
                'existencia' => 0,
                'status' => 1,
                'ptosVenta' => 1,
                'ptosCompra' => 1,
                'vtaFechaProceso' => 0
            ],
            [
                'tipo' => 'Ad',
                'description' => 'LS-90 SUB. PLOMO',
                'corta' => 'LS-90',
                'costo' => 12.2,
                'existencia' => 0,
                'status' => 1,
                'ptosVenta' => 1,
                'ptosCompra' => 1,
                'vtaFechaProceso' => 0
            ],
            [
                'tipo' => 'Ot',
                'description' => 'ADITIVO P/DIESEL 950 ML',
                'corta' => 'ADDI9',
                'costo' => 75.4,
                'existencia' => 66,
                'status' => 1,
                'ptosVenta' => 1,
                'ptosCompra' => 1,
                'vtaFechaProceso' => 0
            ],
            [
                'tipo' => 'Ad',
                'description' => 'TOP OIL PREMIUM 473 ML',
                'corta' => 'TOPRE',
                'costo' => 98.2,
                'existencia' => 10,
                'status' => 1,
                'ptosVenta' => 1,
                'ptosCompra' => 1,
                'vtaFechaProceso' => 0
            ],
            [
                'tipo' => 'Ot',
                'description' => 'LIMPIA PARABRISAS 1000 ML',
                'corta' => 'LIMBA',
                'costo' => 21.5,
                'existencia' => 0,
                'status' => 1,
                'ptosVenta' => 1,
                'ptosCompra' => 1,
                'vtaFechaProceso' => 0
            ],
            [
                'tipo' => 'Ad',
                'description' => 'TOP OIL ECO SAVER 473 ML',
                'corta' => 'TOPECO',
                'costo' => 75,
                'existencia' => 10,
                'status' => 1,
                'ptosVenta' => 1,
                'ptosCompra' => 1,
                'vtaFechaProceso' => 0
            ],
            [
                'tipo' => 'Ot',
                'description' => 'COOLANT CUBETA',
                'corta' => 'COCUB19',
                'costo' => 356.5526,
                'existencia' => 0,
                'status' => 1,
                'ptosVenta' => 1,
                'ptosCompra' => 1,
                'vtaFechaProceso' => 0
            ],

           
          
         
           

          
        ];


        DB::connection('sqlsrv_synergo')->table('CatAceites')->insert($productos);
    }
}
