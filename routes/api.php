<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PackController;
use App\Http\Controllers\PasswordRecoveryController;
use App\Http\Controllers\PromoCodeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('emailVerification', [EmailVerificationController::class, 'firstLogin']);
Route::post('validEmail', [EmailVerificationController::class, 'validEmail']);
Route::post('register', [AuthController::class, 'register']);
Route::get('/test/{id}', [RoleController::class, 'getUserRoleAndPermissions']);


Route::get('/packs', [PackController::class, 'index']);

Route::post('lead', [LeadController::class, 'store']);
Route::post('order', [OrderController::class, 'store']);

Route::post('checkPromoCode', [PromoCodeController::class, 'checkPromoCode']);


Route::post('passwordRecovery/request', [PasswordRecoveryController::class, 'passwordRecoveryRequest']);
Route::post('passwordRecovery/change', [PasswordRecoveryController::class, 'passwordRecoveryChange']);
Route::middleware('auth:api')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::middleware('isAdmin')->group(function () {
        Route::get('/protected-route', function (Request $request) {
            return response()->json(['message' => 'You have accessed the protected route']);
        });

        Route::prefix('leads')->group(function () {
            Route::get('/', [LeadController::class, 'index']);

        });
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
            Route::post('givenToRole/{role}/{permissions}', [RoleController::class, 'givePermissionsToRole']);
        });

        Route::prefix('orders')->group(function () {
            Route::get('/getMyOrders', [OrderController::class, 'getMyOrders']);
        });

    });

});


