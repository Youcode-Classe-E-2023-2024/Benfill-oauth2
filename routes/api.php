<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\RolePermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api');

Route::middleware('auth:api')->group(function () {
    Route::middleware('isAdmin')->group(function () {

        Route::prefix('users')->group(function () {
            Route::get('/', [UserController::class, 'index']);
            Route::post('/', [UserController::class, 'store']);
            Route::get('/{id}', [UserController::class, 'getUserDetails']);
            Route::put('/{id}', [UserController::class, 'update']);
            Route::delete('/{id}', [UserController::class, 'destroy']);
        });

        Route::prefix('role')->group(function () {
            Route::post('assign', [UserController::class, 'assignRole']);
            Route::post('store', [RoleController::class, 'storeRole']);
        });

        Route::prefix('permission')->group(function () {
            Route::post('store', [RoleController::class, 'storePermission']);
            Route::post('givenToRole', [RoleController::class, 'givePermissionsToRole']);
        });

    });

});


