<?php

use App\Http\Controllers\AuthController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::middleware('auth:api')->group(function () {
    Route::get('users', [User::class, 'index']);
    Route::post('users', [User::class, 'store']);
    Route::put('users/{id}', [User::class, 'update']);
    Route::delete('users/{id}', [User::class, 'destroy']);
});
