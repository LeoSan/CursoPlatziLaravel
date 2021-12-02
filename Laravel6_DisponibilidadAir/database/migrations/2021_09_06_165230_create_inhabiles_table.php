<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInhabilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inhabiles', function (Blueprint $table) {
            $table->id()->comment('Identificador único');
            $table->unsignedBigInteger('persona_id')->nullable()->comment('Llave foránea nullable de la persona a la que se le inhabilitará la fecha');
            $table->date('fecha')->comment('Fecha que no estará disponible');
            $table->string('descripcion')->comment('Descripción de la fecha que se inhabilita');
            $table->unsignedBigInteger('plataforma_id')->comment('ID de la plataforma a la que se inhabilita la fecha');
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
        Schema::dropIfExists('inhabiles');
    }
}
