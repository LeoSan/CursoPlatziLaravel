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
        Schema::create('usuario_jurisdiccion', function (Blueprint $table) {
            $table->id()->comment('Identificador único');
            $table->unsignedBigInteger('usuario_id')->comment('ID del usuario');
            $table->unsignedBigInteger('municipio_id')->comment('ID del municipio asociada al usuario');
            $table->timestamps();
            $table->softDeletes();

            $table->index('usuario_id');

            $table->foreign('municipio_id')
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
        Schema::dropIfExists('usuario_jurisdiccion');
    }
};
