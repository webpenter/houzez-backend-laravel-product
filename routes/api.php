<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\Auth\UserProfileController;
use App\Http\Controllers\BedroomController;
use App\Http\Controllers\Message\MessageController;
use App\Http\Controllers\Message\MessageReplyController;
use App\Http\Controllers\Property\PropertyController;
use App\Http\Controllers\Property\PropertyImageController;
use App\Http\Controllers\Property\SubPropertiesController;
use App\Http\Controllers\Property\FloorPlansController;
use App\Http\Controllers\Property\PropertyAttachmentController;
use App\Http\Controllers\Property\AppPropertyController;
use App\Http\Controllers\Property\FavoritePropertyController;
use App\Http\Controllers\Setting\GeneralSettingController;
use App\Http\Controllers\StripePayment\PlanController;
use App\Http\Controllers\StripePayment\SubscriptionController;
use App\Http\Controllers\StripePayment\InvoicesController;
use App\Http\Controllers\NewsletterSubscribe\NewsletterSubscribeController;
use App\Http\Controllers\Others\SavedSearchController;

Route::prefix('v1')->group(function () {
    // Authentication routes
    Route::controller(UserController::class)->group(function () {
        Route::post('/register', 'register');
        Route::post('/login', 'login');
    });

    // App routes
    Route::prefix('app')->group(function () {
        // Properties-related routes
        Route::prefix('properties')->controller(AppPropertyController::class)->group(function () {
            Route::get('/get-featured', 'getFeaturedProperties');
            Route::get('/get-searched-and-filtered', 'getSearchedAndFilteredProperties');
            Route::get('/get-all', 'getAllProperties');
        });

        // Newsletter-Subscribe related route
        Route::post('/subscribe', [NewsletterSubscribeController::class, 'subscribe']);
    });

    // Dashboard routes
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
        });

        // Properties-related routes
        Route::prefix('properties')->group(function () {
            // General-properties related routes
            Route::controller(PropertyController::class)->group(function () {
                Route::get('/get-user', 'getUserProperties');
                Route::post('/create-or-update/{property?}', 'createOrUpdate')->middleware('checkPropertyLimit');
                Route::get('/edit/{property}', 'edit');
                Route::post('/delete/{property}', 'destroy');
                Route::post('/duplicate/{property}', 'duplicate');
            });

            // Property-images related routes
            Route::controller(PropertyImageController::class)->group(function () {
                Route::post('/images/create-or-update/{property}', 'imagesCreateOrUpdate');
                Route::get('/images/edit/{property}', 'getImages');
                Route::post('/image/delete/{property}/{image}', 'deleteImage');
                Route::post('/thumbnail/update/{property}/{image}', 'updateThumbnail');
            });

            // Property-attachments related routes
            Route::controller(PropertyAttachmentController::class)->group(function () {
                Route::post('/attachments/create-or-update/{property}', 'storeOrUpdate');
                Route::get('/attachments/edit/{property}', 'edit');
                Route::post('/attachments/delete/{attachment}', 'delete');
            });

            // Sub-properties related routes
            Route::controller(SubPropertiesController::class)->group(function () {
                Route::post('/{property}/sub-properties/{subProperty?}',  'createOrUpdate');
            });

            // Floor-plans related routes
            Route::controller(FloorPlansController::class)->group(function () {
                Route::post('/{property}/floor-plans/{floorPlan?}', 'createOrUpdate');
            });

            // Favorites-properties related routes
            Route::prefix('favorites')->controller(FavoritePropertyController::class)->group(function () {
                Route::get('/get-user', 'index');
                Route::post('/add-or-remove/{property}', 'addOrRemove');
                Route::get('/is-favorite/{property}', 'isFavorite');
                Route::post('/delete/{favoriteProperty}', 'destroy');
            });
        });

        // Saved-searches related routes
        Route::prefix('saved-searches')->controller(SavedSearchController::class)->group(function () {
            Route::get('/get-user', 'getUserSearches');
            Route::post('/store', 'store');
            Route::post('/delete/{id}', 'destroy');
        });

        // Stripe-payments related routes
        Route::prefix('stripe-payments')->group(function () {
            // Plans related routes
            Route::controller(PlanController::class)->middleware('isAdmin')->group(function () {
                Route::get('/get-all-plans', 'getAllPlans');
                Route::get('/get-select-plans', 'getSelectPlans')->withoutMiddleware('isAdmin');
                Route::post('/store-plan', 'storePlan');
                Route::post('/update-plan/{plan}', 'updatePlan');
                Route::post('/delete-plan/{plan}', 'deletePlan');
            });

            // Subscription related routes
            Route::controller(SubscriptionController::class)->group(function () {
                Route::get('/checkout/{plan}', 'checkout');
                Route::post('/process', 'process');
                Route::get('/get-user-subscriptions', 'getUserSubscriptions');
                Route::get('/cancel-subscription', 'cancelSubscription');
                Route::get('/resume-subscription', 'resumeSubscription');
            });

            // Invoices related routes
            Route::get('/invoices',[InvoicesController::class,'invoices']);

        });

        Route::prefix('settings')->group(function () {
            Route::get('/general', [GeneralSettingController::class, 'index']);
            Route::post('/create', [GeneralSettingController::class, 'createOrUpdateGeneralSettings']);
        });

        // bedroom routes
        // Route::prefix('bedrooms')->group(function () {
        //     Route::get('/', [BedroomController::class, 'index']); // List all bedrooms
        //     Route::post('/create', [BedroomController::class, 'store']); // Create a new bedroom
        //     Route::get('/{bedroom}', [BedroomController::class, 'show']); // Get single bedroom (Model Binding)
        //     Route::post('/update/{bedroom}', [BedroomController::class, 'update']); // Update bedroom (Model Binding)
        //     Route::post('/delete/{bedroom}', [BedroomController::class, 'destroy']); // Delete bedroom (Model Binding)
        // });
    });

});
