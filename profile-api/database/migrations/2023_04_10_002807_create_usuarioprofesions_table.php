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
        Schema::create('usuario_profesiones', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('Clave Primaria');
            $table->bigInteger('professions_id')->comment('Clave Foranea');
            $table->bigInteger('users_id')->comment('Clave Foranea');
            $table->string('desc_bio', 1500)->nullable()->comment('Campo descripción, permite al usuario crear una mini biografia ');
            $table->string('contacto_uno', 12)->nullable()->comment('Campo contacto teléfonico Uno, esto si tiene mas de un telefono ');
            $table->string('contacto_dos', 12)->nullable()->comment('Campo contacto teléfonico Dos, esto si tiene mas de un telefono');
            $table->string('enlace_uno', 1000)->nullable()->comment('Campo enlace Uno, para añadir alguna red social, esto viene con la opción premium');
            $table->string('enlace_dos', 1000)->nullable()->comment('Campo enlace Dos, para añadir alguna red social, esto viene con la opción premium');
            $table->boolean('activo')->default(FALSE)->comment('Permite valida si esta activa o no la categoria');
            $table->timestamps();
            //Deifnición clave foraneas
            $table->index('professions_id');
            $table->index('users_id');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usuario_profesiones');
    }
};
