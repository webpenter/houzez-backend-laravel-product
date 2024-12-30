<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserProfileController;

Route::prefix('v1')->group(function () {
    // Authentication routes
    Route::controller(UserController::class)->group(function () {
        Route::post('/register', 'register')->name('register');
        Route::post('/login', 'login')->name('login');
        Route::post('/logout', 'logout')->name('logout');
    });

    // Protected routes
    Route::middleware('auth:sanctum')->group(function () {
        // User-related routes
        Route::controller(UserController::class)->group(function () {
            Route::get('/user', function (Request $request) {
                return $request->user();
            })->name('user');

            Route::put('/change-password', 'changePassword')->name('changePassword');
            Route::delete('/delete-account', 'deleteAccount')->name('deleteAccount');
        });

        // Profile-related routes
        Route::controller(UserProfileController::class)->group(function () {
            Route::put('/profile/update', 'updateInformation')->name('updateProfile');
            Route::put('/social-media/update', 'updateSocialMedia')->name('updateSocialMedia');
        });
    });
});
