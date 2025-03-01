<?php

use App\Http\Controllers\AccountController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/xss-bezWalidacji', function () {
    $input = request('input', '');
    return "<div>Wprowadzone dane: $input</div>";
});



Route::get('/xss-zWalidacja', function () {
    $input = request('input', '');
    return "<div>Wprowadzone dane: " . e($input) . "</div>";
});


Route::post('/delete-account', [AccountController::class, 'delete']);

Route::post('/delete-account', [AccountController::class, 'delete'])->middleware('auth');




