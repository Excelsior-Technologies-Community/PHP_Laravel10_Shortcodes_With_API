<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ShortcodeController;

Route::get('/posts', [ShortcodeController::class, 'index']);
Route::get('/posts/{id}', [ShortcodeController::class, 'show']);
Route::put('/posts/{id}', [ShortcodeController::class, 'update']);
Route::delete('/posts/{id}', [ShortcodeController::class, 'destroy']);

Route::post('/posts', [ShortcodeController::class, 'store']);
Route::post('/parse', [ShortcodeController::class, 'parse']);

Route::post('/files/upload', [ShortcodeController::class, 'upload']);
Route::get('/files', [ShortcodeController::class, 'files']);
Route::post('/files/{id}', [ShortcodeController::class, 'fileDelete']);

// History Routes

Route::get('/history', [ShortcodeController::class, 'history']);

Route::get('/history/{id}', [ShortcodeController::class, 'historyShow']);

Route::post('/history/{id}', [ShortcodeController::class, 'historyDelete']);