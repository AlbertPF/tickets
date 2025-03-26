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
        Schema::create('oficinas', function (Blueprint $table) {
            $table->string('id_oficina', 7)->primary();
            $table->string('codigo', 11)->nullable();
            $table->string('nombre', 120)->nullable();
            $table->longText('descripcion')->nullable();
            $table->integer('anio')->nullable();
            $table->string('id_oficina_padre', 7)->nullable();
            $table->timestamps();

            $table->foreign('id_oficina_padre')->references('id_oficina')->on('oficinas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('oficinas');
    }
};
