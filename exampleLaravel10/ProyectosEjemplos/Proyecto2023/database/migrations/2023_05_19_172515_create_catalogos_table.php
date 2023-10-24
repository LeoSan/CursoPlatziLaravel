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
        Schema::create('catalogos', function (Blueprint $table) {
            $table->id()->comment('Identificador único');
            $table->string('nombre',255)->comment('Texto visual de la opción');
            $table->string('codigo',100)->comment('Código para programación');
            $table->unsignedBigInteger('parent_id')->nullable()->comment('Identificador del catálogo padre');
            $table->string('singular')->nullable()->comment('Nombre singular de los elementos del catálogo');
            $table->boolean('editable')->comment('Permiso para editar')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('catalogos');
    }
};
