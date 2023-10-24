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
        Schema::create('convenios', function (Blueprint $table) {
            $table->id()->comment('Identificador único');
            $table->unsignedBigInteger('caso_id')->comment('ID del caso al que esta relacionado');
            $table->unsignedBigInteger('resolucion_id')->comment('ID de la resolución');
            $table->string('num_pagos',500)->comment('Total de pagos');
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
        Schema::dropIfExists('convenios');
    }
};
