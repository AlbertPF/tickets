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
        Schema::create('ticket_notificacion', function (Blueprint $table) {
            $table->string('id_notificacion', 7)->primary();
            $table->string('id_ticket', 7);
            $table->string('id_usuario', 7);
            $table->boolean('abierta')->default(false);
            $table->timestamp('enviada_en')->nullable();
            $table->timestamp('abierta_en')->nullable();
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
        Schema::dropIfExists('ticket_notificacion');
    }
};
