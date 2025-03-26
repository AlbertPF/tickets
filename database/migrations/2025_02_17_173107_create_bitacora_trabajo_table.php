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
        Schema::create('bitacora_trabajo', function (Blueprint $table) {
            $table->string('id_bitacora', 7)->primary();
            $table->string('estado', 1)->nullable();
            $table->dateTime('fecha_reg')->nullable();
            $table->string('doc_ref', 100)->nullable();
            $table->longText('descripcion')->nullable();
            $table->dateTime('fecha_aten')->nullable();
            $table->string('doc_aten', 100)->nullable();
            $table->string('id_actividad', 7)->nullable();
            $table->string('id_oficina', 7)->nullable();
            $table->string('id_usuario', 7)->nullable();
            $table->timestamps();

            $table->foreign('id_actividad')->references('id_actividad')->on('actividades')->onDelete('cascade');
            $table->foreign('id_oficina')->references('id_oficina')->on('oficinas')->onDelete('cascade');
            $table->foreign('id_usuario')->references('id_usuario')->on('usuarios')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bitacora_trabajo');
    }
};
