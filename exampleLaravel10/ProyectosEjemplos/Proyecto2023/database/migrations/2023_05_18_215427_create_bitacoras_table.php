<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bitacora', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('Campo PK de la tabla bitacora');
            $table->unsignedBigInteger('usuario_id')->comment('Campo FK relacionado con la tabla usuario');
            $table->string('componente')->nullable()->comment('Código del componente o sección donde está ocurriendo el movimiento');
            $table->string('subcomponente')->nullable()->comment('Código del subcomponente');
            $table->string('accion')->nullable()->comment('Acción relacionada al registro en la tabla');
            $table->text('descripcion')->nullable()->comment('Descripción corta del movimiento que se está realizando, Ejemplo: Se editó la información del usuario “Pepe Lopez”');
            $table->text('datos')->nullable()->comment('Permite indicar que dato se registro y que dato se actualizo.');
            $table->unsignedBigInteger('dependencia_id')->comment('Campo que permite identificar el id de la dependencia');
            $table->string('codigo_dependencia')->comment('Campo que permite identificar el código de la dependencia');
            $table->string('usuario_ip')->nullable()->comment('Se guardará la ip del usuario o plataforma que está realizando el movimiento');
            $table->nullableMorphs('modelo');
            $table->timestamps();

            $table->index('usuario_id');
            $table->index('componente');
            $table->index('subcomponente');
            $table->index('accion');
            $table->index('dependencia_id');
            $table->index('codigo_dependencia');

            $table->index('modelo_id')->comment('ID del tipo de referencia, Ejemplo: si se está editando un usuario en referencia_id se coloca el id del usuario que se está editando.');
            $table->index('modelo_type')->comment('El nombre de la tabla/entidad a la que corresponde el valor del campo id de este registro.');

            $table->foreign('usuario_id')
              ->references('id')
              ->on('users')
              ->onDelete('cascade');

        });

    }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bitacora');
    }
};
