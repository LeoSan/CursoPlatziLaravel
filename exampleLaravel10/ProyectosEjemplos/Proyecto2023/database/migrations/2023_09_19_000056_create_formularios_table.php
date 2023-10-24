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
        Schema::create('formularios', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->comment('Nombre del formulario');
            $table->unsignedBigInteger('tipo_inspeccion_id')->comment('Indica el ID del tipo de inspección al que está ligado');
            $table->unsignedBigInteger('estatus_id')->comment('Indica el ID del estatus del formulario');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('tipo_inspeccion_id')->references('id')->on('catalogo_elementos');
            $table->foreign('estatus_id')->references('id')->on('catalogo_elementos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('formularios');
    }
};
