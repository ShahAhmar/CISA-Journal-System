<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\JournalApiController;
use App\Http\Controllers\Api\SettingsApiController;

// Public API Routes
Route::prefix('v1')->group(function () {
    // Website Settings
    Route::get('/settings', [SettingsApiController::class, 'index']);
    
    // Homepage Data
    Route::get('/homepage', [JournalApiController::class, 'homepage']);
    
    // Journals
    Route::get('/journals', [JournalApiController::class, 'homepage']); // Same as homepage for now
    Route::get('/journals/{slug}', [JournalApiController::class, 'show']);
    Route::get('/journals/{slug}/articles', [JournalApiController::class, 'articles']);
    
    // Search
    Route::get('/search', [JournalApiController::class, 'search']);
});

// Authenticated API Routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});

