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
        Schema::create('secciones', function (Blueprint $table) {
            $table->id()->comment('Identificador único');
            $table->string('nombre')->comment('Nombre de la sección');
            $table->string('codigo')->comment('Código para programación');
            $table->unsignedBigInteger('modulo_id')->comment('Identificador del modulo');
            $table->timestamps();
            $table->softDeletes();

            $table->index('modulo_id');

            $table->foreign('modulo_id')
                ->references('id')
                ->on('catalogo_elementos')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('secciones');
    }
};
