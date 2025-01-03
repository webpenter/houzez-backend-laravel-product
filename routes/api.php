<?php

use App\Http\Controllers\ListingController;
use App\Http\Controllers\PropertyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserProfileController;

// Route::prefix('v1')->group(function () {
    // Authentication routes
    Route::controller(UserController::class)->group(function () {
        Route::post('/register', 'register');
        Route::post('/login', 'login')->name('login');
        Route::get('/login', 'login')->name('login');
        Route::post('/logout', 'logout')->name('logout');
        
    // });

    // Protected routes
    Route::middleware('auth:sanctum')->group(function () {
        // User-related routes
        Route::controller(UserController::class)->group(function () {
            Route::get('/user', function (Request $request) {
                return $request->user();
            });
            // Route::apiResource('properties', PropertyController::class);

            Route::post('/logout', 'logout');
            Route::put('/change-password', 'changePassword');
            Route::delete('/delete-account', 'deleteAccount');
            Route::get('/properties', [PropertyController::class, 'index']);        // List properties
            Route::post('/properties/store', [PropertyController::class, 'store']);      // Create property
            Route::put('/properties/{property}', [PropertyController::class, 'update']); // Update property
            Route::delete('/properties/{property}', [PropertyController::class, 'destroy']); // Delete property
    Route::get('listings', [ListingController::class, 'index']); // Get all listings
    Route::post('listings', [ListingController::class, 'store']); // Create a new listing
    Route::get('listings/{id}', [ListingController::class, 'show']); // Get a single listing by ID
    Route::put('listings/{id}', [ListingController::class, 'update']); // Update a listing
    Route::delete('listings/{id}', [ListingController::class, 'destroy']); // Delete a listing
        });

        // Profile-related routes
        Route::controller(UserProfileController::class)->group(function () {
            Route::put('/profile/update', 'updateInformation');
            Route::put('/social-media/update', 'updateSocialMedia');
        });
    });
   
});
