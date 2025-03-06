onnection('sqlsrv_synergo')-><?php

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
        Schema::connection('sqlsrv_synergo')->create('ctg_despachadores', function (Blueprint $table) {
            $table->id();
            $table->integer('nu_despachador')->nullable(); // ID principal
            $table->string('descripcion', 255);
            $table->string('nip', 50)->nullable();
            $table->integer('nu_isla')->nullable();
            $table->integer('turno')->nullable();
            $table->string('llavero')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('sqlsrv_synergo')->dropIfExists('ctg_despachadores');
    }
};
