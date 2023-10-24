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
        Schema::create('documentos', function (Blueprint $table) {
            $table->id()->comment('Identificador único');
            $table->string('tipo_entidad')->comment('Campo que identifica el modelo relacionado con el tipo ejemplo [Casos y Denuncias Otros] ');
            $table->unsignedBigInteger('entidad_id')->comment('Campo Clave foranea que identifica la entidad');
            $table->unsignedBigInteger('tipo_documento_id')->comment('ID de la opción vinculada a catalogo de tipo de documento');
            $table->unsignedBigInteger('dependencia_id')->comment('ID de la opción vinculada a catalogo de dependencias');
            $table->string('ruta',500)->comment('ruta donde se encuentra cargado el documento');
            $table->string('nombre',500)->comment('nombre del documento');
            $table->string('descripcion', 500)->comment('Campo que permite describir el documento');
            $table->timestamp('fecha_recepcion')->comment('fecha de recepcion del documento');
            $table->string('num_oficio',255)->nullable()->comment('número de oficio que indica el documento');
            $table->date('fecha_oficio')->nullable()->comment('fecha del oficio que indica el documento');
            $table->string('num_expediente',255)->nullable()->comment('número de expediente que indica el documento');
            $table->string('extension',5)->nullable()->comment('extension que indique el formato del archivo');
            $table->string('peso',20)->nullable()->comment('peso original del archivo');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('tipo_documento_id')
                ->references('id')
                ->on('catalogo_elementos')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('dependencia_id')
                ->references('id')
                ->on('catalogo_elementos')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documentos');
    }
};
