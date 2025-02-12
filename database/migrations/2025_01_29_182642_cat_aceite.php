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
        Schema::connection('sqlsrv_synergo')->create('catAceites', function (Blueprint $table) {
            $table->id();
            $table->string('tipo');
            $table->string('description');
            $table->string('corta');
            $table->float('costo')->default(0);
            $table->integer('existencia')->default(0);
            $table->integer('status')->default(1);
            $table->integer('ptosVenta')->default(1);
            $table->integer('ptosCompra')->default(1);
            $table->integer('vtaFechaProceso')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('sqlsrv_synergo')->dropIfExists('catAceites');
    }
};
