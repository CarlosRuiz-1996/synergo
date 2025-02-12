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
        Schema::connection('sqlsrv_synergo')->create('ctg_combustibles', function (Blueprint $table) {
            $table->id();
            $table->integer('nu_combustible')->nullable();; // ID principal
            $table->string('descripcion', 255);
            $table->decimal('costo', 10, 2)->nullable();
            $table->decimal('merma', 10, 2)->nullable();
            $table->decimal('flete', 10, 2)->nullable();
            $table->decimal('venta', 10, 2)->nullable();
            $table->string('corta', 50)->nullable();
            $table->integer('ptos_compra')->nullable();
            $table->integer('ptos_venta')->nullable();
            $table->string('clv_pemex', 50)->nullable();
            $table->string('color_tq', 50)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('sqlsrv_synergo')->dropIfExists('ctg_combustibles');
    }
};
