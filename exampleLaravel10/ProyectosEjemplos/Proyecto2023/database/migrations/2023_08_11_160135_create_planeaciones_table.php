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
        Schema::create('planeaciones', function (Blueprint $table) {
            $table->id()->comment('Identificador único');
            $table->string('anio',4)->nullable()->comment('Año donde se ejecutara el plan de auditoria');
            $table->text('objetivo')->nullable()->comment('Objetivo del plan de auditoria');
            $table->text('alcance')->nullable()->comment('Alcance del plan de auditoria');
            $table->text('criterio')->nullable()->comment('Criterios del plan anual');
            $table->text('recursos')->nullable()->comment('Recursos del plan anual');
            $table->unsignedBigInteger('estatus_id')->nullable()->comment('ID del estatus del plan anual');
            $table->text('recursos')->nullable()->comment('Recursos del plan anual')->change();
            $table->timestamps();
            $table->softDeletes();

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
        Schema::dropIfExists('planeaciones');
    }
};
