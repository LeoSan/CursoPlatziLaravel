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
        Schema::create('denuncia_informes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('denuncia_id')->comment('ID de la denuncia al que esta relacionado');
            $table->text('observaciones')->nullable()->comment('Observaciones de la denuncia');
            $table->boolean('visita_campo')->default(false)->comment('Campo booleano de realización de visita en campo');
            $table->text('comentarios')->nullable()->comment('Comentarios del jefe de auditoría acerca del informe de la denuncia');
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
        Schema::dropIfExists('denuncia_informes');
    }
};
