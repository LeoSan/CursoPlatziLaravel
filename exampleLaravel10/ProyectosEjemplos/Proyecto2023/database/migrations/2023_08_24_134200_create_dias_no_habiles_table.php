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
        Schema::create('dias_no_habiles', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('Clave Primaria');
            $table->integer('creador_id')->comment('ID del usuario que esta registrando la actividad en el sistema ');
            $table->integer('dependencia_id')->nullable()->comment('plataforma id');
            $table->date('fecha')->comment('Fecha no laborable');
            $table->string('descripcion', 250)->nullable()->comment('Descripción de la fecha no laborable');
            $table->integer('anio')->comment('Anio que pertence el día no laboral');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dias_no_habiles');
    }
};
