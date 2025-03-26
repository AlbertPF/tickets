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
        Schema::create('usuarios', function (Blueprint $table) {
            $table->string('id_usuario', 7)->primary();
            $table->string('dni', 8)->nullable();
            $table->string('nombre', 25)->nullable();
            $table->string('apellidoPaterno', 25)->nullable();
            $table->string('apellidoMaterno', 25)->nullable();
            $table->string('usuario', 25)->nullable();
            $table->string('password')->nullable();
            $table->string('tipo', 50)->nullable();
            $table->string('telefono')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
