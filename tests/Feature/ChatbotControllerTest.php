<?php

namespace Tests\Feature;

use App\Models\ChatbotInteraction;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class ChatbotControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config([
            'database.default' => 'sqlite',
            'database.connections.sqlite.database' => ':memory:',
        ]);
        DB::purge('sqlite');
        DB::setDefaultConnection('sqlite');

        Schema::create('chatbot_interactions', function (Blueprint $table) {
            $table->id();
            $table->timestamp('started_at');
            $table->timestamp('ended_at')->nullable();
            $table->integer('message_count')->default(0);
            $table->integer('successful_responses')->default(0);
            $table->integer('failed_responses')->default(0);
            $table->string('model_used')->nullable();
            $table->timestamps();
        });

        config([
            'app.debug' => true,
            'services.openrouter.key' => 'test-key',
            'services.openrouter.endpoint' => 'https://openrouter.test/chat/completions',
            'services.openrouter.max_tokens' => 2048,
        ]);
    }

    public function test_it_tries_the_next_model_for_recoverable_openrouter_errors(): void
    {
        config([
            'services.openrouter.models' => [
                'model/not-found:free',
                'model/rate-limited:free',
                'model/bad-gateway:free',
                'model/unavailable:free',
                'model/available:free',
            ],
        ]);

        Http::fakeSequence('https://openrouter.test/*')
            ->push(['error' => ['message' => 'Model not found']], 404)
            ->push(['error' => ['message' => 'Rate limit exceeded']], 429)
            ->push(['error' => ['message' => 'Bad gateway']], 502)
            ->push(['error' => ['message' => 'Service unavailable']], 503)
            ->push([
                'choices' => [
                    ['message' => ['content' => 'El asistente funciona.']],
                ],
                'usage' => ['total_tokens' => 42],
            ], 200);

        $response = $this->postJson('/api/chatbot/message', [
            'message' => 'Necesito ayuda con mi impresora.',
        ]);

        $response
            ->assertOk()
            ->assertJson([
                'success' => true,
                'reply' => 'El asistente funciona.',
                'model_used' => 'model/available:free',
                'tokens_used' => 42,
            ]);

        Http::assertSentCount(5);

        $interaction = ChatbotInteraction::firstOrFail();
        $this->assertSame(1, $interaction->message_count);
        $this->assertSame(1, $interaction->successful_responses);
        $this->assertSame(0, $interaction->failed_responses);
    }

    public function test_it_returns_the_real_openrouter_message_in_debug_mode(): void
    {
        config(['services.openrouter.models' => ['model/unauthorized:free']]);

        Http::fake([
            'https://openrouter.test/*' => Http::response([
                'error' => ['message' => 'API key is invalid.'],
            ], 401),
        ]);

        $response = $this->postJson('/api/chatbot/message', [
            'message' => 'Hola',
        ]);

        $response
            ->assertStatus(401)
            ->assertJson([
                'success' => false,
                'model_used' => 'model/unauthorized:free',
                'error' => 'OpenRouter (401) [model/unauthorized:free]: API key is invalid.',
            ]);

        Http::assertSentCount(1);
    }

    public function test_it_hides_the_openrouter_message_when_debug_is_disabled(): void
    {
        config([
            'app.debug' => false,
            'services.openrouter.models' => ['model/unauthorized:free'],
        ]);

        Http::fake([
            'https://openrouter.test/*' => Http::response([
                'error' => ['message' => 'Sensitive upstream detail.'],
            ], 401),
        ]);

        $response = $this->postJson('/api/chatbot/message', [
            'message' => 'Hola',
        ]);

        $response
            ->assertStatus(401)
            ->assertJson([
                'success' => false,
                'error' => 'El asistente no pudo procesar la solicitud en este momento.',
            ])
            ->assertJsonMissing(['error' => 'Sensitive upstream detail.']);
    }
}
