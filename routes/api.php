<?php

use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\TelegramController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/telegram/webhook', [TelegramController::class, 'webhook']);
// Route::post('/chatbot/message', [ChatbotController::class, 'handleMessage'])->middleware('auth'); // Opcional: Requiere login
// Route::post('/chatbot/message', [ChatbotController::class, 'handleMessage']);
Route::middleware('api')->group(function () {
    Route::post('/chatbot/message', [ChatbotController::class, 'handleMessage'])
        ->name('api.chatbot.message');
});

Route::post('/chatbot/start', [ChatbotController::class, 'startInteraction'])
    ->name('api.chatbot.start');
Route::post('/chatbot/end-interaction', [ChatbotController::class, 'endInteraction'])
    ->name('api.chatbot.end-interaction');
