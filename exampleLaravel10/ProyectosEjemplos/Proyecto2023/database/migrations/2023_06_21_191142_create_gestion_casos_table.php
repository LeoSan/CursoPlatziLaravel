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
        Schema::create('gestion_casos', function (Blueprint $table) {
            $table->id()->comment('Identificador único');
            $table->unsignedBigInteger('caso_id')->comment('ID del caso relacionada');
            $table->unsignedBigInteger('estatus_id')->comment('ID del estatus relacionado');
            $table->text('observacion')->nullable()->comment('Observación del estatus');
            $table->unsignedBigInteger('usuario_asignado_id')->comment('ID del usuario al que se le asigna el caso');
            $table->unsignedBigInteger('creador_id')->comment('ID del usuario que realizó el registro');
            $table->unsignedBigInteger('motivo_id')->nullable()->comment('ID del del catalogo de motivos de rechazo');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('caso_id')
                 ->references('id')
                 ->on('casos')
                 ->onDelete('cascade')
                 ->onUpdate('cascade');

            $table->foreign('usuario_asignado_id')
                 ->references('id')
                 ->on('users')
                 ->onDelete('cascade')
                 ->onUpdate('cascade');

            $table->foreign('creador_id')
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
        Schema::dropIfExists('gestion_casos');
    }
};
