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
        Schema::create('representantes_legales', function (Blueprint $table) {
            $table->id()->comment('Identificador único');
            $table->unsignedBigInteger('empresa_id')->comment('ID de la empresa al que esta relacionado');
            $table->string('num_identificacion',500)->nullable()->comment('numero de la identificación del representante legal');
            $table->string('nombre',500)->nullable()->comment('nombre completo del representante legal');
            $table->string('correo',500)->nullable()->comment('correo electrónico de la empresa');
            $table->string('telefono',50)->nullable()->comment('telefono de la empresa');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('empresa_id')
                ->references('id')
                ->on('empresas')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('representantes_legales');
    }
};
