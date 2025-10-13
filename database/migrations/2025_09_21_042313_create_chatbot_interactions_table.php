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
        Schema::create('chatbot_interactions', function (Blueprint $table) {
            $table->id();
            $table->timestamp('started_at'); // Fecha y hora de apertura            
            $table->integer('message_count')->default(0); // Cantidad de mensajes enviados
            $table->integer('successful_responses')->default(0); // Respuestas exitosas
            $table->integer('failed_responses')->default(0); // Respuestas fallidas
            $table->string('model_used')->nullable(); // Modelo de IA usado (último modelo)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chatbot_interactions');
    }
};
