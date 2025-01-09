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
        Route::post('/login', 'login')->name('login');
        Route::get('/login', 'login')->name('login');
        Route::get('/register', 'register');
        Route::post('/logout', 'logout')->name('logout');
       
     });

    // Protected routes
    Route::middleware('auth:sanctum')->group(function () {
        // User-related routes
        Route::controller(UserController::class)->group(function () {
            Route::get('/user', function (Request $request) {
                return $request->user();
            });
            // Get all invoices
    Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoices.index');

    // Get a single invoice
    Route::get('/invoices/{id}', [InvoiceController::class, 'show'])->name('invoices.show');

    // Create a new invoice
    Route::post('/invoices/store', [InvoiceController::class, 'store'])->name('invoices.store');

    // Update an existing invoice
    Route::put('/invoices/{id}', [InvoiceController::class, 'update'])->name('invoices.update');

    // Delete an invoice
    Route::delete('/invoices/{id}', [InvoiceController::class, 'destroy'])->name('invoices.destroy');
            
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
            // Route::get('/properties-location', [PropertyLocationController::class, 'index']);        // List properties
            // Route::post('/properties-location/store', [PropertyLocationController::class, 'store']);
            //    // Create property
            // Route::put('/properties-location/{property}', [PropertyLocationController::class, 'update']); // Update property
            // Route::delete('/properties-location/{property}', [PropertyLocationController::class, 'destroy']); // Delete property
        });

        // Profile-related routes
        Route::controller(UserProfileController::class)->group(function () {
            Route::put('/profile/update', 'updateInformation');
            Route::put('/social-media/update', 'updateSocialMedia');
        });
    });
   
// });
