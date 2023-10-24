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
        Schema::table('planeacion_auditoria_ejecuciones', function (Blueprint $table) {
            $table->boolean('informe_auditoria')->default(false)->comment('Indica si ya se cargo el informe de la auditoria');
            $table->boolean('auditoria_no_ejecutada')->default(false)->comment('Indica si la auditoría no fue ejecutada');
            $table->boolean('hallazgos_a_notificar')->default(false)->comment('Indica si la auditoria tiene hallazgos a notificar');
            $table->boolean('seguimiento')->default(false)->comment('Indica si se dará seguimiento a la auditoría');
            $table->date('fecha_seguimiento')->nullable()->comment('Fecha que se le dará seguimiento a la auditoría');

            $table->text('proposito_lista')->nullable()->comment('Propósito de la lista de verificación de la ejecución');
            $table->text('fuentes_lista')->nullable()->comment('Fuentes de la lista de verificación de la ejecución');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('planeacion_auditoria_ejecuciones', function (Blueprint $table) {
            $table->dropColumn('auditoria_no_ejecutada');
            $table->dropColumn('hallazgos_a_notificar');
            $table->dropColumn('seguimiento');
            $table->dropColumn('fecha_seguimiento');
            $table->dropColumn('proposito_lista');
            $table->dropColumn('fuentes_lista');
        });
    }
};
