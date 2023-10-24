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
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('Identificador único');
            $table->string('name')->comment('Nombre del usuario');
            $table->string('first_name')->comment('Primer apellido del usuario');
            $table->string('last_name')->nullable()->comment('Segundo apellido del usuario');
            $table->string('complete_name');
            $table->string('email')->unique()->comment('Correo electrónico');
            $table->timestamp('email_verified_at')->nullable()->comment('Verificación del correo electrónico');
            $table->string('phone')->nullable()->comment('Teléfono');
            $table->unsignedBigInteger('dependencia_id')->comment('ID de la dependencia');
            $table->unsignedBigInteger('regional_id')->comment('ID de la regional');
            $table->unsignedBigInteger('area_adscripcion_id')->comment('ID del área de adscripción');
            $table->string('cargo')->comment('Cargo del usuario');
            $table->unsignedBigInteger('perfil_id')->comment('ID del perfil');
            $table->boolean('activo')->default(true)->comment('Indica si el usuario está activo o no');
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
