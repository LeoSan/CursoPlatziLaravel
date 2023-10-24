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
        Schema::create('planeacion_solicitud_expedientes', function (Blueprint $table) {
            $table->id();
            $table->string('numero_oficio')->nullable()->comment('Campo número del oficio');
            $table->date('fecha_solicitud')->comment('Fecha de la solicitud de expedientes');
            $table->unsignedBigInteger('regional_id')->comment('ID de la regional');
            $table->integer('mes')->nullable()->comment('Mes en el que se lleva a cabo la auditoria');
            $table->unsignedBigInteger('auditor_realizo_solicitud')->nullable()->comment('ID del usuario creador de la solicitud');
            $table->unsignedBigInteger('auditor_asignado_id')->nullable()->comment('ID del auditor asignado');
            $table->unsignedBigInteger('auditor_jefe_regional_id')->nullable()->comment('ID del usuario asignado jefe regional');
            $table->integer('total_expdientes_solicitados')->nullable()->comment('Total de expedientes solicitados');
            $table->unsignedBigInteger('estatus_id')->nullable()->comment('ID del estatus de la auditoría');
            $table->boolean('vencido')->nullable()->comment('valida si el plazo esta vencido luego de 10 dias habiles')->default(null);
            $table->boolean('expediente_fisico')->nullable()->comment('Permite indicar si esta vencido en conjunto del crontab')->default(null);
            $table->date('fecha_expediente_fisico')->nullable()->comment('Fecha de expediente físico');
            $table->integer('plazo_respuesta_solicitud')->default(10)->comment('Días para el plazo de vencimiento para dar respuesta solicitud');
            
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('regional_id')
                ->references('id')
                ->on('catalogo_elementos')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('auditor_realizo_solicitud')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('auditor_asignado_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('auditor_jefe_regional_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('estatus_id')
                ->references('id')
                ->on('catalogo_elementos')
                ->onDelete('cascade')
                ->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('planeacion_solicitud_expedientes');
    }
};
