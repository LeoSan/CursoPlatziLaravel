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
        Schema::create('planeacion_auditorias', function (Blueprint $table) {
            $table->id()->comment('Identificador único');
            $table->unsignedBigInteger('planeacion_id')->nullable()->comment('ID del plan anual al que esta relacionado');
            $table->unsignedBigInteger('departamento_id')->nullable()->comment('ID de la opción vinculada a catalogo de departamentos');
            $table->unsignedBigInteger('municipio_id')->nullable()->comment('ID de la opción vinculada a catalogo de municipios');
            $table->unsignedBigInteger('tipo_inspeccion_id')->comment('ID de la opción vinculada a catalogo de tipo de inspección');
            $table->unsignedBigInteger('actividad_economica_id')->comment('ID de la opción vinculada a catalogo de actividad economica relacionada con el plan anual de auditoria');
            $table->string('cafta',2)->nullable()->comment('sí, no');
            $table->unsignedBigInteger('creador_id')->nullable()->comment('ID del usuario que creo el registro');
            $table->unsignedBigInteger('auditor_responsable_id')->nullable()->comment('ID del auditor responsable de las auditorias');
            $table->unsignedBigInteger('estatus_id')->nullable()->comment('ID del estatus del plan anual');
            $table->unsignedBigInteger('total_auditorias')->nullable()->comment('Suma total de auditorias');
            $table->unsignedBigInteger('region_id')->nullable()->comment('ID de la opción vinculada a catalogo de regiones');
            $table->timestamps();
            $table->softDeletes();


            $table->foreign('planeacion_id')
                ->references('id')
                ->on('planeaciones')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('departamento_id')
                ->references('id')
                ->on('catalogo_elementos')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('municipio_id')
                ->references('id')
                ->on('catalogo_elementos')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('tipo_inspeccion_id')
                ->references('id')
                ->on('catalogo_elementos')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('actividad_economica_id')
                ->references('id')
                ->on('catalogo_elementos')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('creador_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('auditor_responsable_id')
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
        Schema::dropIfExists('planeacion_auditorias');
    }
};
