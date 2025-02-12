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
        Schema::connection('sqlsrv_synergo')->create('ctg_proveedores', function (Blueprint $table) {
            $table->id();
            $table->integer('nu_proveedor');
            $table->string('nombre', 255);
            $table->string('rfc', 20)->nullable();
            $table->string('calle', 255)->nullable();
            $table->string('colonia', 255)->nullable();
            $table->string('ciudad', 255)->nullable();
            $table->string('edo', 255)->nullable();
            $table->string('cp', 10)->nullable();
            $table->string('tel', 20)->nullable();
            $table->string('fax', 20)->nullable();
            $table->string('contacto', 255)->nullable();
            $table->decimal('credito', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('sqlsrv_synergo')->dropIfExists('ctg_proveedores');
    }
};
