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
        Schema::create('personals', function (Blueprint $table) {
            $table->string('id_personal', 7)->primary();
            $table->string('dni', 8)->nullable();
            $table->string('nombre', 25)->nullable();
            $table->string('apellidoPaterno', 25)->nullable();
            $table->string('apellidoMaterno', 25)->nullable();
            $table->string('estado', 1)->nullable();
            $table->string('telefono')->nullable();
            $table->string('id_rl', 7)->nullable();
            $table->timestamps();
            
            $table->foreign('id_rl')->references('id_rl')->on('regimen_laborals');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personals');
    }
};
