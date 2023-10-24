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
        Schema::create('denuncias', function (Blueprint $table) {
            //Datos del denunciante
            $table->bigIncrements('id')->comment('Campo PK');
            $table->string('folio')->unique()->comment('Indica el folio de la denuncia ');
            $table->string('num_expediente_dgit')->nullable()->comment('Indica el folio de la denuncia ');
            $table->unsignedBigInteger('origen_id')->comment('Campo FK relacionado con la tabla catalogo elemento');
            $table->string('nombre_denunciante', '255')->comment('Campo del nombre denunciante');
            $table->string('primer_apellido_denunciante', '255')->comment('Campo del primer apellido denunciante');
            $table->string('segundo_apellido_denunciante', '255')->nullable()->comment('Campo del segundo apellido denunciante');
            $table->string('telefono_denunciante', '25')->nullable()->comment('Campo del telefono denunciante');
            $table->string('correo_denunciante', '255')->comment('Campo del correo denunciante');
            $table->string('sindicato_denunciante', '255')->nullable()->comment('Campo que describe el nombre del sindicato');
            $table->string('dni_denunciante', '20')->nullable()->comment('Campo que describe el nombre del sindicato');
            //Datos de la denuncia
            $table->string('nombre_funcionario', '255')->comment('Campo del nombre funcionario');
            $table->unsignedBigInteger('oficina_regional_id')->nullable()->comment('Campo FK relacionado con la tabla catalogo elemento');
            $table->unsignedBigInteger('region_departamento_id')->comment('Campo FK relacionado con la tabla catalogo elemento');
            $table->unsignedBigInteger('region_municipio_id')->comment('Campo FK relacionado con la catalogo elemento');
            $table->text('descripcion_denuncia')->comment('Descripción de la denuncia');
            $table->longText('descripcion_denuncia_adicional')->nullable()->default(null)->comment('Descripción de la denuncia adicional');
            //Datos pruebas y evidencias
            $table->boolean('cuenta_con_pruebas')->comment('Indica si cuenta con pruebas si o no');
            $table->unsignedBigInteger('estatus_id')->comment('Clave foranea para definir el estatus');
            $table->unsignedBigInteger('usuario_asignado_id')->nullable()->comment('ID del usuario responsable en turno para atender el caso');
            $table->text('num_expediente', 100)->nullable()->comment('Numero de expediente generado por el sistema y la nomenclatura asignada');
            $table->text('correo_dgit', 150)->nullable()->comment('Indica que el auditor si enviará correo dgit');
            $table->boolean('visita')->nullable()->comment('Indica si la respuesta de providencia fue de manera fisica');
            $table->unsignedBigInteger('medio_recepcion_id')->nullable()->comment('Permite ingresar el medio recepcion');
            $table->integer('cont_noti_auditor')->nullable()->default(0)->comment('Permite llevar el conteo de días habilesa para avisarle al auditor'); 
            $table->unsignedBigInteger('tipo_inspeccion_id')->nullable();
            $table->unsignedBigInteger('caracter_id')->nullable();
            $table->integer('cont_plazo_maximo')->nullable()->default(0)->comment('Permite llevar el conteo de días habiles si el plazo ha vencido y la denuncia no está en estatus');
            
            
            $table->timestamps();

            //Relaciones
            $table->foreign('region_departamento_id')->references('id')->on('catalogo_elementos')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('region_municipio_id')->references('id')->on('catalogo_elementos')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('origen_id')->references('id')->on('catalogo_elementos')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('oficina_regional_id')->references('id')->on('catalogo_elementos')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('estatus_id')->references('id')->on('catalogo_elementos')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('usuario_asignado_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('medio_recepcion_id')->references('id')->on('catalogo_elementos')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('tipo_inspeccion_id')->on('catalogo_elementos')->references('id');
            $table->foreign('caracter_id')->on('catalogo_elementos')->references('id');

            
            //index
            $table->index('folio');
            $table->index('tipo_inspeccion_id');
            $table->index('caracter_id');


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('denuncias');
    }
};
