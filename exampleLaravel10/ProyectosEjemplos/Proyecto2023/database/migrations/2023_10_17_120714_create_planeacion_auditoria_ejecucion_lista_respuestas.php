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
        Schema::create('planeacion_auditoria_ejecucion_lista_respuestas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ejecucion_id')->comment('ID de la ejecución');
            $table->unsignedBigInteger('pregunta_id')->comment('ID de la pregunta');
            $table->string('respuesta')->nullable()->comment('Respuesta de la pregunta');
            $table->string('observaciones',300)->nullable()->comment('Observaciones de la respuesta');
            $table->timestamps();
            $table->foreign('ejecucion_id')
                ->on('planeacion_auditoria_ejecuciones')
                ->onDelete('cascade')
                ->references('id');
            $table->foreign('pregunta_id')
                ->on('formulario_seccion_preguntas')
                ->onDelete('cascade')
                ->references('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('planeacion_auditoria_ejecucion_lista_respuestas');
    }
};
