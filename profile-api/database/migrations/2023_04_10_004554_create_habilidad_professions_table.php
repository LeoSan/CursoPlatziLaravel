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
        Schema::create('habilidad_professions', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('Clave Primaria');
            $table->bigInteger('usuario_profesiones_id')->comment('Clave Foranea');
            $table->string('nom_habilidades', 100)->nullable()->comment('Campo nombre habilidades.');
            $table->boolean('activo')->default(FALSE)->comment('Permite valida si esta activa o no la categoria');
            $table->timestamps();
            //Deifnición clave foraneas
            $table->index('usuario_profesiones_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('habilidad_professions');
    }
};
