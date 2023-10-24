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
        Schema::create('tipo_infracciones', function (Blueprint $table) {
            $table->id();
            $table->string('concepto');
            $table->string('anio');
            $table->boolean('editable')->default(false);
            $table->unsignedDecimal('monto',25,2)->nullable();
            $table->boolean('activo')->default(true)->comment('Indica si el tipo de infracción está activo o no');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipo_infracciones');
    }
};
