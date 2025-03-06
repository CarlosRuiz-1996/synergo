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
        Schema::connection('sqlsrv_synergo')->create('ctg_forma_pagos', function (Blueprint $table) {
            $table->id();
            $table->string('nu_forma_pago')->nullable(); // ID principal
            $table->string('descripcion', 255)->nullable();
            $table->string('consulta', 255)->nullable();
            $table->boolean('bnd_factura')->default(false);
            $table->integer('nu_copias')->nullable();
            $table->boolean('bnd_autorizacion')->default(false);
            $table->boolean('bnd_puntada')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('sqlsrv_synergo')->dropIfExists('ctg_forma_pagos');
    }
};
