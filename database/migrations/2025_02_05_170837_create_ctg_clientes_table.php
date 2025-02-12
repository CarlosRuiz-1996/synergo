<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection('sqlsrv_synergo')->create('ctg_clientes', function (Blueprint $table) {
            $table->id();
            $table->integer('nu_cliente')->nullable(); // ID principal
            $table->string('nombre', 255);
            $table->string('rfc', 20)->nullable();
            $table->string('calle', 255)->nullable();
            $table->string('exterior', 10)->nullable();
            $table->string('interior', 10)->nullable();
            $table->string('colonia', 255)->nullable();
            $table->string('localidad', 255)->nullable();
            $table->string('referencia', 255)->nullable();
            $table->string('municipio', 255)->nullable();
            $table->string('edo', 255)->nullable();
            $table->string('pais', 100)->nullable();
            $table->string('cp', 10)->nullable();
            $table->string('tel', 20)->nullable();
            $table->string('fax', 20)->nullable();
            $table->string('email1', 255)->nullable();
            $table->string('email2', 255)->nullable();
            $table->string('contacto', 255)->nullable();
            $table->string('tipo', 50)->nullable();
            $table->decimal('monto', 10, 2)->nullable();
            $table->string('forma_pago', 50)->nullable();
            $table->integer('puntos')->nullable();
            $table->date('fecha_inicial')->nullable();
            $table->decimal('acumulado', 10, 2)->nullable();
            $table->decimal('actual', 10, 2)->nullable();
            $table->string('nombre_tarjeta', 255)->nullable();
            $table->integer('dia_factura')->nullable();
            $table->string('periodo', 50)->nullable();
            $table->date('fecha_factura')->nullable();
            $table->boolean('rp_conductor')->default(false);
            $table->boolean('rp_tarjeta')->default(false);
            $table->boolean('rp_vehiculo')->default(false);
            $table->boolean('rp_errores')->default(false);
            $table->boolean('rp_ccostos')->default(false);
            $table->boolean('act_facturas')->default(false);
            $table->integer('rp_nu_folios')->nullable();
            $table->boolean('bnd_fac_dia')->default(false);
            $table->float('deposito', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('sqlsrv_synergo')->dropIfExists('ctg_clientes');
    }
};
