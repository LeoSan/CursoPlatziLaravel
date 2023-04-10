<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('experiencia_professions', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('Clave Primaria');
            $table->bigInteger('usuario_profesiones_id')->comment('Clave Foranea');
            $table->bigInteger('jornada_id')->comment('Clave Foranea');
            $table->string('nom_empresa', 150)->nullable()->comment('Campo nombre empresa.');
            $table->string('desc_empresa', 1000)->nullable()->comment('Campo descripción empresa.');
            $table->string('cargo_empresa', 150)->nullable()->comment('Campo cargo empresa.');
            $table->boolean('activo')->default(FALSE)->comment('Permite valida si esta activa o no la categoria');
            $table->timestamps();
            //Deifnición clave foraneas
            $table->index('usuario_profesiones_id');
            $table->index('jornada_id');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('experiencia_professions');
    }
};
