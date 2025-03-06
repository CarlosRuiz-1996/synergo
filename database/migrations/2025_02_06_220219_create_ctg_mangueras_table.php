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
        Schema::connection('sqlsrv_synergo')->create('ctg_mangueras', function (Blueprint $table) {
            $table->id();
            $table->integer('nu_manguera')->nullable(); // ID principal
            $table->integer('nu_isla')->nullable();
            $table->integer('nu_combustible')->nullable();
            $table->integer('nu_pos_carga')->nullable();
            $table->decimal('lec_ini', 15, 2)->nullable();
            $table->string('estado', 50)->nullable();
            $table->integer('nu_cliente')->nullable();
            $table->integer('nu_tarjeta')->nullable();
            $table->boolean('bnd_miles')->default(false);
            $table->integer('nu_antena')->nullable();
            $table->integer('nu_pistola')->nullable();
            $table->timestamp('man_dt_alta')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('sqlsrv_synergo')->dropIfExists('ctg_mangueras');
    }
};
