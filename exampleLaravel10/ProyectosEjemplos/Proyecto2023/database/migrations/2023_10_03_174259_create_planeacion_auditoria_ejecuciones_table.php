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
        Schema::create('planeacion_auditoria_ejecuciones', function (Blueprint $table) {
            $table->id()->comment('Identificador único');
            $table->unsignedBigInteger('planeacion_auditoria_id')->comment('ID del registro mensual de planeacion anual al que esta relacionado');
            $table->string('num_auditoria',65)->nullable()->comment('Identificador de la auditoria asignado');
            $table->date('fecha_acuse_recepcion')->nullable()->comment('Fecha donde se entrega el expediente en forma fisica');
            $table->string('nombre_jefe')->nullable()->comment('Nombre del jefe regional o Local');
            $table->string('cargo')->nullable()->comment('Cargo del servidor publico');
            $table->string('correo')->nullable()->comment('Correo electronico del servidor publico');
            $table->boolean('envio_expediente')->default(false)->comment('Corresponde a la forma que se envia el expediente, 0 - expediete digital, 1 - expediente fisico');
            $table->string('num_oficio')->nullable()->comment('Correo electronico del servidor publico');
            $table->date('fecha_entrega_oficio')->nullable()->comment('Correo electronico del servidor publico');
            $table->longText('observaciones')->nullable()->comment('Información adicional del oficio de envío de expediente');
            $table->unsignedBigInteger('estatus_id')->comment('ID del estatus de la auditoría');
            $table->unsignedBigInteger('auditor_asignado_id')->comment('ID del usuario asignado con permiso de auditor');
            $table->integer('mes')->comment('Mes en el que se lleva a cabo la auditoria');
            $table->integer('num_control')->comment('Numero para control');
            $table->boolean('tiene_expediente')->default(false)->comment('Indica si la auditoría tiene expediente');
            $table->date('fecha_expediente_fisico')->nullable()->comment('Fecha que se recibió el expediente físico');
            $table->longText('observaciones_incumplimiento')->nullable()->comment('Observaciones al existir incumplimientos sin expdientes');
            $table->unsignedBigInteger('solicitud_expediente_id')->nullable()->comment('ID del registro de la solicitud de expedientes de la auditoria');
            $table->timestamps();
            $table->softDeletes();


            $table->foreign('planeacion_auditoria_id')
                ->references('id')
                ->on('planeacion_auditorias')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('estatus_id')
                ->references('id')
                ->on('catalogo_elementos')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('auditor_asignado_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('solicitud_expediente_id')->on('planeacion_solicitud_expedientes')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('planeacion_auditoria_ejecuciones');
    }
};
