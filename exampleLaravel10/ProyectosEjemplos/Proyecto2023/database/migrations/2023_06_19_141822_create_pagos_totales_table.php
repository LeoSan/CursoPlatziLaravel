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
        Schema::create('pagos_totales', function (Blueprint $table) {
            $table->id()->comment('Identificador único');
            $table->unsignedBigInteger('caso_id')->comment('ID del caso al que esta relacionado');
            $table->unsignedBigInteger('resolucion_id')->comment('ID de la resolución');
            $table->timestamp('fecha')->comment('fecha de pago');
            $table->string('num_recibo', '150')->comment('Número de recibo de pago');
            $table->unsignedDecimal('monto',30,2)->comment('Monto pagado de la multa');
            $table->unsignedDecimal('interes',30,2)->comment('Interes de la multa');
            $table->unsignedDecimal('monto_total',30,2)->comment('Monto total de la multa');
            $table->unsignedBigInteger('tipo_pago_id')->nullable()->comment('ID del tipo del pago');
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
        Schema::dropIfExists('pagos_totales');
    }
};
