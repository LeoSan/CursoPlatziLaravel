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
        Schema::create('atencion_denuncia', function (Blueprint $table) {
            $table->id()->comment('Identificador único');
            $table->unsignedBigInteger('denuncia_id')->comment('ID de la denuncia relacionada');
            $table->unsignedBigInteger('expediente_usuario_id')->comment('ID del usuario que realiza la solicitud de expediente');
            $table->string('observaciones_expediente',1700)->nullable()->comment('Información adicional de la solicitud de expediente');
            $table->boolean('notificacion_dgit')->comment('Campo que confirma si se realizara la notificacion al equipo de la DGIT');
            $table->string('num_expediente_dgit',255)->comment('Numero de expediente asignado a la denuncia para la dgit');
            $table->string('num_expediente',255)->comment('Numero de expediente asignado a la denuncia');
            $table->string('observacion_alta',1700)->nullable()->comment('Observación del alta de la denuncia');
            $table->unsignedBigInteger('admision_usuario_id')->comment('ID del usuario que admite la denuncia');
            $table->string('observaciones_admision',1700)->nullable()->comment('Información adicional de la admisión de la denuncia');
            $table->boolean('visita')->comment('Campo que confirma si se realizara la visita de campo');
            $table->longText('observaciones_visita')->nullable()->comment('Información adicional de la visita de campo');
            $table->date('fecha_recepcion_providencia')->nullable()->comment('Campo que almacena la fecha de recepción de la visita por providencia');
            $table->string('observaciones_informe',1700)->nullable()->comment('Información adicional del informe');
            $table->string('observacion_providencia',1700)->nullable()->comment('Información de la providencia');
            $table->string('correo_dgit',150)->nullable()->comment('correo indicativo de la notificacion_dgit');
            $table->timestamps();
            $table->softDeletes();

             $table->foreign('denuncia_id')
                ->references('id')
                ->on('denuncias')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('atencion_denuncia');
    }
};
