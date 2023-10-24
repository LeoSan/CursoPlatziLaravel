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
        Schema::create('planeacion_auditoria_meses', function (Blueprint $table) {
            $table->id()->comment('Identificador único');
            $table->unsignedBigInteger('planeacion_auditoria_id')->nullable()->comment('ID del la auditoría planeada');
            $table->integer('mes')->nullable()->comment('Mes en el que se llevaran las auditorias');
            $table->integer('num_auditorias')->comment('Número de auditorias en el mes');
            $table->timestamps();
            $table->softDeletes();


            $table->foreign('planeacion_auditoria_id')
                ->references('id')
                ->on('planeacion_auditorias')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('planeacion_auditoria_meses');
    }
};
