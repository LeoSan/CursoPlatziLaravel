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
        Schema::create('professions', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('Clave Primaria');
            $table->bigInteger('cate_profesion_id')->comment('Clave Foranea');
            $table->string('nom_profesion', 250)->nullable()->comment('Nombre de la categoria que define a los diferentes tipos de profesiones');
            $table->string('desc_profesion', 500)->nullable()->comment('descripcion de la categoria que define a los diferentes tipos de profesiones');
            $table->boolean('activo')->default(FALSE)->comment('Permite valida si esta activa o no la categoria');
            $table->timestamps();
            //Deifnición clave foraneas
            $table->index('cate_profesion_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('professions');
    }
};
