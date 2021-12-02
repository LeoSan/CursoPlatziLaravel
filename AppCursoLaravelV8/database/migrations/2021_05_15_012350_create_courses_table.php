<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->comment('Clave Foranea');
            $table->unsignedBigInteger('category_id')->comment('Clave Foranea');
            $table->string('name')->comment('nombre del curso');
            $table->string('slug')->comment('enlace corto del curso');
            $table->string('image')->comment('imagen del curso');
            $table->string('description')->comment('Campo descripcion del curso');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');// Campo PK y nombre de la tabla definida en el modelo 
            $table->foreign('category_id')->references('id')->on('categories');// Campo PK y nombre de la tabla definida en el modelo 
    

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('courses');
    }
}
