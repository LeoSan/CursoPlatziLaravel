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
        Schema::create('roles', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('Clave Primaria');
            $table->string('nom_role', 250)->nullable()->comment('Nombre del rol');
            $table->string('dec_role', 500)->nullable()->comment('Descripcion del rol');
            $table->boolean('activo')->default(FALSE)->comment('Permite valida si esta activa o no la categoria');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
};
