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
        Schema::create('formulario_secciones', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->comment('Nombre de la sección');
            $table->unsignedBigInteger('formulario_id')->comment('ID del formulario al que pertenece la sección');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('formulario_id')->references('id')->on('formularios');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('formulario_secciones');
    }
};
