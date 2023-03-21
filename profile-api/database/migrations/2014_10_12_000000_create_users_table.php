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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_rol')->comment('Clave Foranea');
            $table->bigInteger('id_menbresia')->comment('Clave Foranea');
            $table->string('nombre');
            $table->string('apellido');
            $table->string('email')->unique();
            $table->date('nacimiento');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            $table->boolean('activo')->default(TRUE)->comment('Permite valida si esta activa o no. ');

            //Deifnición clave foraneas
            $table->index('id_rol');
            $table->index('id_menbresia');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
