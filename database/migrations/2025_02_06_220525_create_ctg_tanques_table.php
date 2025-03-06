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
        Schema::connection('sqlsrv_synergo')->create('ctg_tanques', function (Blueprint $table) {
            $table->id();
            $table->integer('nu_tanque')->nullable(); // ID principal
            // $table->unsignedBigInteger('nu_combustible'); // Relación con combustible
            $table->decimal('capacidad', 10, 2)->nullable();
            $table->decimal('diametro', 10, 2)->nullable();
            $table->decimal('niv_seg', 10, 2)->nullable();
            $table->decimal('niv_op', 10, 2)->nullable();
            $table->string('edo', 50)->nullable();
            $table->decimal('fondaje', 10, 2)->nullable();
            $table->decimal('capa_oper', 10, 2)->nullable();
            $table->timestamp('tan_dt_alta')->nullable();
            $table->softDeletes();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('sqlsrv_synergo')->dropIfExists('ctg_tanques');
    }
};
