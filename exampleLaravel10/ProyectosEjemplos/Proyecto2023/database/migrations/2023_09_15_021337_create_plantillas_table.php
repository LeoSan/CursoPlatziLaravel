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
        Schema::create('plantillas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->comment('Nombre de la plantilla');
            $table->unsignedBigInteger('seccion_id')->comment('ID de la sección de la plantilla');
            $table->longText('contenido')->nullable()->comment('Contenido html de la plantilla');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('seccion_id')->on('catalogo_elementos')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plantillas');
    }
};
