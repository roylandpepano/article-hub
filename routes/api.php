<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\CategoryController;
use Illuminate\Routing\Middleware\SubstituteBindings;

Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);

Route::get('/articles', [ArticleController::class, 'index']);
Route::post('/articles', [ArticleController::class, 'store'])->middleware('auth');
Route::get('/articles/{article}', [ArticleController::class, 'show']);
Route::put('/articles/{article}', [ArticleController::class, 'update'])
    ->middleware('auth')
    ->withoutMiddleware(SubstituteBindings::class);
Route::delete('/articles/{article}', [ArticleController::class, 'destroy'])
    ->middleware('auth')
    ->withoutMiddleware(SubstituteBindings::class);

Route::get('/categories/{category}', [CategoryController::class, 'show']);
