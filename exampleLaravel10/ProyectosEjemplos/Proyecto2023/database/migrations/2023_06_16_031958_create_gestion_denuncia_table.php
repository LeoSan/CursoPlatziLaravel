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
        Schema::create('gestion_denuncia', function (Blueprint $table) {
            $table->id()->comment('Identificador único');
            $table->unsignedBigInteger('denuncia_id')->comment('ID de la denuncia relacionada');
            $table->unsignedBigInteger('estatus_id')->comment('ID del estatus relacionado');
            $table->unsignedBigInteger('motivo_id')->nullable()->comment('ID del motivo de la atencion de acuerdo al tipo de atencion');
            $table->longText('observacion')->nullable()->comment('Observación de la atención');
            $table->unsignedBigInteger('usuario_asignado_id')->comment('ID del usuario al que se le asigna el caso');
            $table->unsignedBigInteger('creador_id')->nullable()->comment('ID del usuario que realizó el registro');
            $table->boolean('notificado')->default(false)->comment('Indica si se ha notificado el registro (providencia)');
            $table->dateTime('fecha_notificacion_denunciante')->nullable()->comment('Fecha en que se realiza la notificación de recordatorio (providencia) al denunciante');
            $table->dateTime('fecha_notificacion_auditor')->nullable()->comment('Fecha en que se realiza la notificación de desestimación (providencia) al auditor');
            $table->boolean('vencido')->default(false)->comment('Indica si ha vencido el plazo (providencia)');
            $table->datetime('fecha_recepcion')->nullable()->comment('Campo que almacena la fecha de recepción de la visita por providencia');
            $table->timestamps();
            $table->softDeletes();

             $table->foreign('denuncia_id')
                ->references('id')
                ->on('denuncias')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('usuario_asignado_id')
                 ->references('id')
                 ->on('users')
                 ->onDelete('cascade')
                 ->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gestion_denuncia');
    }
};
