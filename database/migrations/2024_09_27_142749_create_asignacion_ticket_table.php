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
        Schema::create('asignacion_ticket', function (Blueprint $table) {
            $table->string('id_Asigticket', 7)->primary();
            $table->string('estado', 1)->nullable();
            $table->dateTime('fecha_asig')->nullable();
            $table->dateTime('fecha_fin')->nullable();
            $table->longText('descripcion')->nullable();
            $table->string('id_ticket', 7)->nullable();
            $table->string('id_usuario', 7)->nullable();
            $table->timestamps();

            $table->foreign('id_ticket')->references('id_ticket')->on('tickets')->onDelete('cascade');
            $table->foreign('id_usuario')->references('id_usuario')->on('usuarios')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asignacion_ticket');
    }
};
