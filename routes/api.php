<?php

use App\Http\Controllers\Api\V1\Agent\AccountingPromptController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');




Route::prefix('v1')->group(function () {
    Route::post('/accounting-prompt', [AccountingPromptController::class, 'accountingPrompt']);
});