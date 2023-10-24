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
        Schema::create('resoluciones', function (Blueprint $table) {
            $table->id()->comment('Identificador único');
            $table->unsignedBigInteger('caso_id')->comment('ID del caso al que esta relacionado');
            $table->unsignedBigInteger('tipo_resolucion_id')->comment('ID de la opción vinculada a catalogo de tipo de resolución');
            $table->unsignedDecimal('monto',30,2)->comment('Cantidad de la multa');
            $table->timestamp('fecha')->comment('Fecha de resolución');
            $table->text('observaciones')->nullable()->comment('Observaciones de la resolución');
            $table->unsignedBigInteger('motivo_id')->nullable()->comment('Motivo de la resolución');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('caso_id')
                ->references('id')
                ->on('casos')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resoluciones');
    }
};
