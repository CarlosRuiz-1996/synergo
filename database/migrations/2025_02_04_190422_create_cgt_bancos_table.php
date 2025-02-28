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
        Schema::connection('sqlsrv_synergo')->create('cgt_bancos', function (Blueprint $table) {
            $table->id();
            $table->string('descripcion');
            $table->integer('no_secuencial')->default(0);
            $table->float('saldo')->default(0);
            $table->integer('imprimir')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('sqlsrv_synergo')->dropIfExists('cgt_bancos');
    }
};
