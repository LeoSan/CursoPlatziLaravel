<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventoPersonasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evento_personas', function (Blueprint $table) {
            $table->id()->comment('Identificador único');
            $table->unsignedBigInteger('evento_id')->comment('ID del evento que se asigna');
            $table->unsignedBigInteger('persona_id')->comment('ID de la la persona a la que se asigna el evento');
            $table->string('observaciones')->nullable()->comment('Observaciones de la asignación del evento');
            $table->timestamps();

            $table->foreign('evento_id')->on('eventos')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('evento_personas');
    }
}
