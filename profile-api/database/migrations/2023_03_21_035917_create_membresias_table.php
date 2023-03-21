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
        Schema::create('Membresias', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('Clave Primaria');
            $table->string('nom_membresia', 250)->nullable()->comment('Nombre del rol');
            $table->string('dec_membresia', 500)->nullable()->comment('Descripcion del rol');
            $table->decimal('precio', 8, 2)->nullable()->comment('Precio ');
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
        Schema::dropIfExists('membresias');
    }
};
