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
        Schema::create('sanciones', function (Blueprint $table) {
            $table->id()->comment('Identificador único');
            $table->unsignedBigInteger('caso_id')->comment('ID del caso al que esta relacionado');
            $table->unsignedBigInteger('tipo_id')->comment('ID de la opción vinculada a la tabla de tipo de infracciones');
            $table->unsignedDecimal('cantidad_multa',25,2)->comment('cantidad de la multa');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('caso_id')
                ->references('id')
                ->on('casos')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('tipo_id')
                ->references('id')
                ->on('tipo_infracciones')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sanciones');
    }
};
