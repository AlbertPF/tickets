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
        Schema::create('tickets', function (Blueprint $table) {
            $table->string('id_ticket', 7)->primary();
            $table->string('estado', 1)->nullable();
            $table->dateTime('fecha_env')->nullable();
            $table->longText('descripcion')->nullable();
            $table->string('id_soporte', 7)->nullable();
            $table->string('id_OfiPer', 7)->nullable();
            $table->timestamps();

            $table->foreign('id_soporte')->references('id_soporte')->on('soportes')->onDelete('cascade');
            $table->foreign('id_OfiPer')->references('id_OfiPer')->on('oficina_personals')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
