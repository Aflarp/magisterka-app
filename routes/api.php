<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

Route::post('/loginWithCorrectScope', [AuthController::class, 'loginWithCorrectScope']);
Route::post('/loginWithInccorectScope', [AuthController::class, 'loginWithInccorectScope']);
Route::post('/loginWithoutExpiresToken', [AuthController::class, 'loginWithoutExpiresToken']);
Route::post('/loginWithExpiresToken', [AuthController::class, 'loginWithExpiresToken']);
Route::post('/loginWithOneToken', [AuthController::class, 'loginWithOneToken']);
Route::post('/loginWithManyToken', [AuthController::class, 'loginWithManyToken']);
Route::post('/registerWithCorrectLog', [AuthController::class, 'registerWithCorrectLog']);
Route::post('/registerWithInccorectLog', [AuthController::class, 'registerWithInccorectLog']);

Route::post('/IncorrectloginWithRedirect', [UserController::class, 'IncorrectloginWithRedirect']);
Route::post('/CorrectloginWithRedirect', [UserController::class, 'CorrectloginWithRedirect']);
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/users/{id}', [UserController::class, 'view']);
    Route::put('/users/{id}', [UserController::class, 'edit']);
});

RateLimiter::for('login', function ($request) {
    return Limit::perMinute(1)->by($request->ip());
});
Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:login');


Route::get('/getUserWithoutSQLI', [UserController::class, 'getUserWithoutSQLI']);
Route::get('/getUserWithSQLI', [UserController::class, 'getUserWithSQLI']);
