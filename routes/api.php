<?php

use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\PropertyLocationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserProfileController;

//  Route::prefix('v1')->group(function () {
     //Authentication routes
    Route::controller(UserController::class)->group(function () {
        Route::post('/register', 'register');
        Route::post('/login', 'login')->name('login'); //named routes
        Route::post('/logout', 'logout')->name('logout');  
     });

    // Protected routes
    Route::middleware('auth:sanctum')->group(function () {
        // User-related routes
        Route::controller(UserController::class)->group(function () {
            Route::get('/user', 'getUser');

            Route::post('/logout', 'logout');
            Route::put('/change-password', 'changePassword');
            Route::delete('/delete-account', 'deleteAccount');
            Route::get('/messages', [MessageController::class, 'index']);        // List properties
            Route::post('/messages/store', [MessageController::class, 'store']);
               // Create property
            Route::put('/messages/{message}', [MessageController::class, 'update']); // Update property
            Route::delete('/messages/{messages}', [MessageController::class, 'destroy']);

            Route::get('/properties', [PropertyController::class, 'index']);        // List properties
            Route::post('/properties/store', [PropertyController::class, 'store']);
               // Create property
            Route::put('/properties/{property}', [PropertyController::class, 'update']); // Update property
            Route::delete('/properties/{property}', [PropertyController::class, 'destroy']); // Delete property
        });

        // Profile-related routes
        Route::prefix('profile')->controller(UserProfileController::class)->group(function () {
            Route::get('/get-information',  'getProfileInformation');
            Route::put('/update-information', 'updateInformation');
            Route::get('/get-picture',  'getProfilePicture');
            Route::post('/update-picture',  'updateProfilePicture');
            Route::put('/update-social-media', 'updateSocialMedia');
        });
    });
});
