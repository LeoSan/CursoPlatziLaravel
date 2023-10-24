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
        Schema::create('demandas', function (Blueprint $table) {
            $table->id()->comment('Identificador único');
            $table->unsignedBigInteger('caso_id')->comment('ID del caso al que esta relacionado');
            $table->unsignedBigInteger('resolucion_id')->comment('ID de la resolución');
            $table->timestamp('fecha')->comment('fecha de la demanda');
            $table->string('num_expediente',255)->comment('folio de la demanda');
            $table->string('nom_juzgado',255)->comment('Nombre del juzgado');
            $table->string('nom_juez',255)->comment('Nombre del juez');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('caso_id')
                ->references('id')
                ->on('casos')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('resolucion_id')
                ->references('id')
                ->on('resoluciones')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('demandas');
    }
};
