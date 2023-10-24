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
        Schema::create('catalogo_elementos', function (Blueprint $table) {
            $table->id()->comment('Identificador único');
            $table->unsignedBigInteger('catalogo_id')->comment('ID de la opción padre vinculada a catalogo');
            $table->string('nombre',255)->comment('Texto visual del elemento');
            $table->string('codigo',100)->comment('Código para programación');
            $table->string('descripcion',255)->nullable()->comment('Nota descriptiva del elemento');
            $table->unsignedBigInteger('parent_id')->nullable()->comment('ID de la opcion padre de esta misma tabla');
            $table->unsignedBigInteger('categoria_id')->nullable()->comment('ID de la opción de la categoria vinculada a catalogo');
            $table->bigInteger('orden')->nullable()->comment('Secuencia de ordenamiento');
            $table->timestamps();
            $table->softDeletes();


            $table->index('catalogo_id');

            $table->foreign('catalogo_id')
                ->references('id')
                ->on('catalogos')
                ->onDelete('cascade')
                ->onUpdate('cascade');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('catalogo_elementos');
    }
};
