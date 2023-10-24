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
        Schema::create('pagos', function (Blueprint $table) {
            $table->id()->comment('Identificador único');
            $table->unsignedBigInteger('convenio_id')->comment('ID del convenio al que está relacionado');
            $table->integer('num_pago')->comment('Número de pago');
            $table->unsignedDecimal('monto',25,2)->comment('Cantidad de la multa');
            $table->timestamp('fecha')->comment('Fecha de pago');
            $table->string('num_recibo')->nullable()->comment('Número de recibo');
            $table->boolean('pagado')->default(false)->comment('Indica si el pago ya fue realizado');
            $table->date('fecha_pagado')->comment('Fecha de pago')->nullable();
            $table->unsignedDecimal('intereses',25,2)->comment('Cantidad de intereses pagados')->default(0);
            $table->unsignedDecimal('monto_pagado',25,2)->comment('Cantidad total pagada sin intereses')->nullable();
            $table->unsignedDecimal('monto_pagado_intereses',25,2)->comment('Cantidad total pagada con intereses')->nullable();
            $table->boolean('vencido')->default(false)->comment('Indica si el pago venció');
            $table->date('fecha_vencimiento')->nullable()->comment('Fecha del vencimiento del pago');
            $table->boolean('prima')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('convenio_id')
                ->references('id')
                ->on('convenios')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};
