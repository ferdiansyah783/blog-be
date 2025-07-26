<?php

use App\Http\Controllers\Api\Admin\AuthController;
use App\Http\Controllers\Api\Admin\SummaryController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\Admin\PostController as AdminPostController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::get('/posts', [PostController::class, 'index']);
    Route::get('/posts/{slug}', [PostController::class, 'show']);
});

Route::post('/auth/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/auth/me', [AuthController::class, 'me']);
    
    Route::prefix('admin')->group(function () {
        Route::get('/summary/count/{status?}', [SummaryController::class, 'count']);
        Route::apiResource('posts', AdminPostController::class)->except(['create', 'edit']);
    });
});
