<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ShortcodeController;

Route::get('/posts', [ShortcodeController::class, 'index']);
Route::get('/posts/{id}', [ShortcodeController::class, 'show']);

Route::post('/posts', [ShortcodeController::class, 'store']);
Route::post('/parse', [ShortcodeController::class, 'parse']);
