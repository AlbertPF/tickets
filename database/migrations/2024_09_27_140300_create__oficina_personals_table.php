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
        Schema::create('oficina_personals', function (Blueprint $table) {
            $table->string('id_OfiPer', 7)->primary();
            $table->string('estado', 1)->nullable();
            $table->integer('anio')->nullable();
            $table->string('id_oficina', 7)->nullable();
            $table->string('id_personal', 7)->nullable();
            $table->timestamps();

            $table->foreign('id_oficina')->references('id_oficina')->on('oficinas')->onDelete('cascade');
            $table->foreign('id_personal')->references('id_personal')->on('personals')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('oficina_personals');
    }
};
