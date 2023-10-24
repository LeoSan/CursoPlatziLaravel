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
        Schema::create('gestion_auditorias', function (Blueprint $table) {
            $table->id()->comment('Identificador único');
            $table->unsignedBigInteger('planeacion_solicitud_expediente_id')->comment('ID planeacion_solicitud_expediente_id');
            $table->unsignedBigInteger('estatus_id')->comment('ID del estatus relacionado');
            $table->unsignedBigInteger('motivo_id')->nullable()->comment('ID del motivo de la atencion de acuerdo al tipo de atencion');
            $table->longText('observacion')->nullable()->comment('Observación de la atención');
            $table->unsignedBigInteger('usuario_asignado_id')->comment('ID del usuario al que se le asigna el caso');
            $table->unsignedBigInteger('creador_id')->nullable()->comment('ID del usuario que realizó el registro');
            $table->boolean('notificado')->nullable()->comment('Permite notificar al usuario correspondiente');
            $table->date('fecha_notificacion_auditor')->nullable()->comment('Fecha de notificación');
            $table->date('fecha_solicitud')->comment('Fecha solicitud ma un dia habil.');
            $table->boolean('vencido')->nullable()->comment('valida si el plazo esta vencido luego de 10 dias habiles')->default(null);
            $table->unsignedBigInteger('auditor_jefe_regional_id')->nullable()->comment('ID del usuario auditor jefe regional al que se le asigna el caso');
           
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('planeacion_solicitud_expediente_id')
                ->references('id')
                ->on('planeacion_solicitud_expedientes')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('usuario_asignado_id')
                 ->references('id')
                 ->on('users')
                 ->onDelete('cascade')
                 ->onUpdate('cascade');

            $table->foreign('estatus_id')
                 ->references('id')
                 ->on('catalogo_elementos')
                 ->onDelete('cascade')
                 ->onUpdate('cascade');

            $table->foreign('auditor_jefe_regional_id')
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
        Schema::dropIfExists('gestion_auditorias');
    }
};
