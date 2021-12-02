<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eventos', function (Blueprint $table) {
            $table->id()->comment('Identificador único');
            $table->unsignedBigInteger('evento_id')->nullable()->comment('Id del evento (plataforma)');
            $table->string('titulo')->nullable()->comment('Título del evento');
            $table->string('tipo')->nullable()->default('generico')->comment('Tipo del evento');
            $table->date('fecha')->comment('Tipo del evento');
            $table->string('codigo_estado')->nullable()->comment('Codigo del estado donde se llevará a cabo el evento');
            $table->string('municipio_alcaldia')->nullable()->comment('Codigo del municipio/alcaldía donde se llevará a cabo el evento');
            $table->string('cp')->nullable()->comment('Codigo postal donde se llevará a cabo el evento');
            $table->string('referencia')->nullable()->comment('Nombre de la referencia del evento');
            $table->unsignedBigInteger('referencia_id')->comment('Id de la referencia del evento');
            $table->unsignedBigInteger('plataforma_id')->comment('Id de la plataforma a la que pertenece el evento');
            $table->string('estatus')->default('pendiente')->comment('Estatus del evento');
            $table->string('latitud')->nullable()->comment('Latitud del evento');
            $table->string('longitud')->nullable()->comment('Longitud del evento');
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
        Schema::dropIfExists('eventos');
    }
}
