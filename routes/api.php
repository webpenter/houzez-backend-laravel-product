<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\Property\PropertyController;

Route::prefix('v1')->group(function () {

    // Unauthentication routes
    Route::controller(UserController::class)->group(function () {
        Route::post('/register', 'register');
        Route::post('/login', 'login');
    });

    // Protected routes
    Route::middleware('auth:sanctum')->group(function () {

        // User-related routes
        Route::controller(UserController::class)->group(function () {
            Route::get('/user', 'getUser');
            Route::post('/logout', 'logout');
            Route::post('/change-password', 'changePassword');
            Route::delete('/delete-account', 'deleteAccount');
        });

        // Profile-related routes
        Route::prefix('profile')->controller(UserProfileController::class)->group(function () {
            Route::get('/get-information',  'getProfileInformation');
            Route::post('/update-information', 'updateInformation');
            Route::get('/get-picture',  'getProfilePicture');
            Route::post('/update-picture',  'updateProfilePicture');
            Route::get('/get-social-media', 'getSocialMedia');
            Route::post('/update-social-media', 'updateSocialMedia');
//            Route::post('/update-social-media', 'updateSocialMedia');
        });

        Route::prefix('properties')->controller(PropertyController::class)->group(function () {
            Route::post('/create-or-update/{id?}', 'storeOrUpdate');
        });

        // Properties-related routes
        Route::prefix('properties')->controller(PropertyController::class)->group(function () {
            Route::get('/', [PropertyController::class, 'index']);
            Route::get('/{property}', [PropertyController::class, 'show']);
            Route::post('/create/step1', [PropertyController::class, 'storestep1']);
            Route::post('/create/step2/{property}', [PropertyController::class, 'storestep2']);
            Route::post('/create/step3/{property}', [PropertyController::class, 'storestep3']);
            Route::post('/create/step4/{property}', [PropertyController::class, 'storestep4']);
            Route::post('/create/step5/{property}', [PropertyController::class, 'storestep5']);
            Route::post('/create/step6/{property}', [PropertyController::class, 'storestep6']);
            Route::post('/create/step7/{property}', [PropertyController::class, 'storestep7']);
            Route::post('/create/step10/{property}', [PropertyController::class, 'storestep10']);
            Route::post('/create/step12/{property}', [PropertyController::class, 'storestep12']);
            // Route::post('/{property}', [PropertyController::class, 'update']);
            Route::post('/{property}', [PropertyController::class, 'destroy']);
        });

    });
});
