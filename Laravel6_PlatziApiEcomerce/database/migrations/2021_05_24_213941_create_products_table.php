<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('categories_id');
            $table->string('name')->comment("Campo Nombre del producto");
            $table->float('price')->comment("Campo Precio del producto");


             //Creao mi relacion foranea
           // $table->bigInteger('category_id')->unsigned();
            $table->foreign('categories_id')->references('id')->on('categories')->comment('Clave Foranea');;

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
        Schema::dropIfExists('products');
    }
}
