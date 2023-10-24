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
        Schema::create('formulario_seccion_preguntas', function (Blueprint $table) {
            $table->id();
            $table->text('pregunta')->comment('Contenido de la pregunta');
            $table->text('descripcion')->nullable()->comment('Descripción de la pregunta, utilizada para mostrar tooltip en el listado de preguntas');
            $table->unsignedBigInteger('seccion_id')->comment('Indica el id de la sección del formulario a la que está vinculada la pregunta');
            $table->unsignedBigInteger('formulario_id')->comment('Indica el id del formulario al que está vinculada la pregunta');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('seccion_id')->on('formulario_secciones')->references('id');
            $table->foreign('formulario_id')->on('formularios')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('formulario_seccion_preguntas');
    }
};
