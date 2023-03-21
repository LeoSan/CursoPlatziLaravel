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
        Schema::create('cat_profesiones', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('Clave Primaria');
            //$table->bigInteger('usuario_id')->comment('ID del usuario de la actividad');
            $table->string('nom_categoria', 250)->nullable()->comment('Nombre de la categoria que define a los diferentes tipos de profesiones');
            $table->string('desc_categoria', 500)->nullable()->comment('descripcion de la categoria que define a los diferentes tipos de profesiones');
            $table->boolean('activo')->default(FALSE)->comment('Permite valida si esta activa o no la categoria');
            $table->timestamps();
            //$table->index('usuario_id');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cat_profesiones');
    }
};
