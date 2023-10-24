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
        Schema::create('casos', function (Blueprint $table) {
            $table->id()->comment('Identificador único');
            $table->string('folio_registro',255)->nullable()->comment('Folio de registro PGR');
            $table->string('numero_expediente',255)->nullable()->comment('Número del expediente de SETRASS');
            $table->string('numero_expediente_pgr',255)->nullable()->comment('Número del expediente de PGR');

            $table->unsignedBigInteger('departamento_id')->nullable()->comment('ID de la opción vinculada a catalogo de departamentos');
            $table->unsignedBigInteger('municipio_id')->nullable()->comment('ID de la opción vinculada a catalogo de municipios');

            $table->date('fecha_notificacion')->nullable()->comment('Fecha de notificacion');
            $table->time('hora_notificacion')->nullable()->comment('Hora de notificacion');

            $table->date('fecha_registro')->nullable()->comment('Fecha de registro');
            $table->time('hora_registro')->nullable()->comment('Hora de registro');

            $table->date('fecha_recepcion_pgr')->nullable()->comment('Fecha de recepción de PGR');

            $table->unsignedBigInteger('creador_id')->nullable()->comment('ID del usuario que creo el registro');
            $table->unsignedBigInteger('usuario_asignado_id')->nullable()->comment('ID del usuario responsable en turno para atender el caso');
            $table->unsignedBigInteger('estatus_id')->comment('ID de la opción vinculada a catalogo de estatus');

            $table->unsignedDecimal('total_multa',30,2)->default('0.00')->comment('Cantidad total de la multa');
            $table->unsignedDecimal('total_cobrado',30,2)->default('0.00')->comment('Sumatoria del monto de los pagos realizados');
            $table->unsignedDecimal('total_cobrado_intereses',30,2)->default('0.00')->comment('Cantidad total de la multa');
            $table->timestamps();
            $table->softDeletes();


            $table->foreign('departamento_id')
                ->references('id')
                ->on('catalogo_elementos')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('municipio_id')
                ->references('id')
                ->on('catalogo_elementos')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('estatus_id')
                ->references('id')
                ->on('catalogo_elementos')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('creador_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('usuario_asignado_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');

        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('casos');
    }
};
