<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ShortcodeController;

Route::get('/posts', [ShortcodeController::class, 'index']);
Route::get('/posts/{id}', [ShortcodeController::class, 'show']);

Route::post('/posts', [ShortcodeController::class, 'store']);
Route::post('/parse', [ShortcodeController::class, 'parse']);

// History Routes

Route::get('/history', [ShortcodeController::class, 'history']);

Route::get('/history/{id}', [ShortcodeController::class, 'historyShow']);

Route::post('/history/{id}', [ShortcodeController::class, 'historyDelete']);