<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatbotController;

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

//Route::post('/chatbot/message', [ChatbotController::class, 'handleMessage'])->middleware('auth'); // Opcional: Requiere login
//Route::post('/chatbot/message', [ChatbotController::class, 'handleMessage']);
Route::middleware('api')->group(function () {
    Route::post('/chatbot/message', [ChatbotController::class, 'handleMessage']);
});

Route::post('/chatbot/start', [ChatbotController::class, 'startInteraction']);
Route::post('/chatbot/end-interaction', [ChatbotController::class, 'endInteraction']);