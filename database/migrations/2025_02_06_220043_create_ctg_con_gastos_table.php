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
        Schema::connection('sqlsrv_synergo')->create('ctg_con_gastos', function (Blueprint $table) {
            $table->id();
            $table->integer('no_gasto')->nullable();
            $table->string('concepto')->nullable();
            $table->string('descripcion')->nullable();
            $table->integer('tipo_gasto')->default(0);
            $table->integer('relacion')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('sqlsrv_synergo')->dropIfExists('ctg_con_gastos');
    }
};
