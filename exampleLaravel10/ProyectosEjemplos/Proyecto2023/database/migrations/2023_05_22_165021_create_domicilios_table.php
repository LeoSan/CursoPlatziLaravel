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
        Schema::create('domicilios', function (Blueprint $table) {
            $table->id()->comment('Identificador único del domicilio');
            $table->unsignedBigInteger('departamento_id')->nullable()->comment('Id del departamento vinculado a catalogo_elementos');
            $table->unsignedBigInteger('municipio_id')->nullable()->comment('Id del municipio vinculado a catalogo_elementos');
            $table->unsignedBigInteger('ciudad_id')->nullable()->comment('Id de la ciudad vinculada a catalogo_elementos');
            $table->string('ciudad')->nullable()->comment('Nombre de la ciudad');
            $table->string('calle',255)->nullable()->comment('Calle');
            $table->string('num_exterior',255)->nullable()->comment('Número exterior del domicilio');
            $table->string('num_interior',255)->nullable()->comment('Número interior del domicilio');
            $table->string('codigo_postal',5)->nullable()->comment('Código postal');
            $table->morphs('entidad');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('departamento_id')->references('id')->on('catalogo_elementos')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('municipio_id')->references('id')->on('catalogo_elementos')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('ciudad_id')->references('id')->on('catalogo_elementos')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('domicilios');
    }
};
