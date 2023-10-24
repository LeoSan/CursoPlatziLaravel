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
        Schema::create('empresas', function (Blueprint $table) {
            $table->id()->comment('Identificador único');
            $table->unsignedBigInteger('caso_id')->comment('ID del caso al que esta relacionado');
            $table->string('nombre_comercial',500)->nullable()->comment('nombre comercial de la empresa');
            $table->string('razon_social',500)->nullable()->comment('razon social de la empresa');
            $table->string('correo',500)->nullable()->comment('correo electrónico de la empresa');
            $table->string('telefono',50)->nullable()->comment('telefono de la empresa');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('caso_id')
                ->references('id')
                ->on('casos')
                ->onDelete('cascade')
                ->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empresas');
    }
};
