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
        Schema::connection('sqlsrv_synergo')->create('ctg_reportes', function (Blueprint $table) {
            $table->id();
            $table->integer('nu_reporte')->nullable(); // ID principal
            $table->string('titulo', 255)->nullable();
            $table->text('consulta')->nullable();
            $table->integer('nivel')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('sqlsrv_synergo')->dropIfExists('ctg_reportes');
    }
};
