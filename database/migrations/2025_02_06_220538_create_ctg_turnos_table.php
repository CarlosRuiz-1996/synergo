connection('sqlsrv_synergo')-><?php

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
        Schema::connection('sqlsrv_synergo')->create('ctg_turnos', function (Blueprint $table) {
            $table->id();
            $table->integer('nu_turno')->nullable(); 
            $table->string('descripcion', 255);
            $table->time('inicio'); // Hora de inicio del turno
            $table->integer('duracion');
            $table->softDeletes();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('sqlsrv_synergo')->dropIfExists('ctg_turnos');
    }
};
