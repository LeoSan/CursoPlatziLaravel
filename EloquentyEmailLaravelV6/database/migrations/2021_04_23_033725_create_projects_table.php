<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 50)->comment('Nombre de ciudades');
            //Esto es para incoporar una clave foranea
            $table->bigInteger('company_id')->unsigned()->comment('Clave Foranea');
            $table->foreign('company_id')->references('id')->on('companies');            
            //Esto es para incoporar una clave foranea
            $table->bigInteger('user_id')->unsigned()->comment('Clave Foranea');
            $table->foreign('user_id')->references('id')->on('users');            
            //Esto es para incoporar una clave foranea
            $table->bigInteger('citie_id')->unsigned()->comment('Clave Foranea');
            $table->foreign('citie_id')->references('id')->on('cities'); 
            
            $table->softDeletes();
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
        Schema::dropIfExists('projects');
    }
}
