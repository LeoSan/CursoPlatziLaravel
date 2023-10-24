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
        Schema::create('planeacion_auditoria_ejecucion_plantillas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('seccion_id')->comment('ID de la sección referenciada');
            $table->unsignedBigInteger('plantilla_id')->comment('ID de la plantilla referenciada');
            $table->unsignedBigInteger('ejecucion_id')->comment('ID de la ejecución');
            $table->string('identificador')->nullable()->comment('Nombre de la cedula');
            $table->longText('contenido')->nullable()->comment('Contenido html de la cedula');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('seccion_id')
                ->on('catalogo_elementos')
                ->onDelete('cascade')
                ->references('id');

            $table->foreign('ejecucion_id')
                ->on('planeacion_auditoria_ejecuciones')
                ->onDelete('cascade')
                ->references('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('planeacion_auditoria_ejecucion_plantillas');
    }
};
