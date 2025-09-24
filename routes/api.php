<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\UserProfileController;
use App\Http\Controllers\Auth\UsersController;
use App\Http\Controllers\Others\NewsletterSubscribeController;
use App\Http\Controllers\Others\SavedSearchController;
use App\Http\Controllers\Property\AppPropertyController;
use App\Http\Controllers\Property\FavoritePropertyController;
use App\Http\Controllers\Property\FloorPlansController;
use App\Http\Controllers\Property\PropertyAttachmentController;
use App\Http\Controllers\Property\PropertyController;
use App\Http\Controllers\Property\PropertyImageController;
use App\Http\Controllers\Property\SubPropertiesController;
use App\Http\Controllers\StripePayment\InvoicesController;
use App\Http\Controllers\StripePayment\PlanController;
use App\Http\Controllers\StripePayment\SubscriptionController;
use App\Http\Controllers\Others\TourRequestController;
use App\Http\Controllers\Others\ReviewController;
use App\Http\Controllers\Others\BlogController;
use App\Http\Controllers\Others\TeamController;
use App\Http\Controllers\Boards\DealController;
use App\Http\Controllers\Boards\LeadController;
use App\Http\Controllers\Boards\EnquiryController;
use App\Http\Controllers\Boards\ActivityController;
use App\Http\Controllers\Insights\InsightController;
use App\Http\Controllers\Agent\AgentController;
use App\Http\Controllers\Agency\AgencyController;
use App\Http\Controllers\Settings\SettingController;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    /* --------------- Login/register routes (without auth) --------------- */
    Route::controller(AuthController::class)->group(function () {
        Route::post('/register', 'register');
        Route::post('/login', 'login');
    });

    /* --------------- App/Client-Side routes (without auth) -------------- */
    Route::prefix('app')->group(function () {
        // App/Properties-related routes
        Route::prefix('properties')->controller(AppPropertyController::class)->group(function () {
            Route::get('/get-featured', 'getFeaturedProperties');
            Route::get('/get-latest', 'getLatestProperties');
            Route::get('/get-searched-and-filtered', 'getSearchedAndFilteredProperties');
            Route::get('/get-all', 'getAllProperties');
            Route::get('/get-property/{slug}', 'getPropertyData');
        });

        // App/Newsletter-Subscribe related route
        Route::post('/subscribe', [NewsletterSubscribeController::class, 'subscribe']);

        // App/Review-system related route
        Route::get('/reviews/show/{propertyId}', [ReviewController::class, 'show']);

        // App/Blogs related route
        Route::get('/blogs', [BlogController::class,'getAppBlogs']);

        // App/Teams related route
        Route::get('/teams', [TeamController::class,'getAppTeams']);

        Route::get('/property/{slug}', [InsightController::class, 'propertyViews']);
    });

    Route::prefix('demo01')->group(function () {
        // App/Demo01/Properties-related routes
        Route::prefix('properties')->controller(AppPropertyController::class)->group(function () {
            Route::get('/get-featured', 'getFeaturedPropertiesDemo01');
            Route::get('/get-latest', 'getLatestPropertiesDemo01');
            Route::get('/get-searched-and-filtered', 'getSearchedAndFilteredPropertiesDemo01');
            Route::get('/get-all', 'getAllPropertiesDemo01');
            Route::get('/get-property/{slug}', 'getPropertyDataDemo01');
            Route::get('/get-property-type/{type}','getPropertyTypeDataDemo01');
            Route::get('/get-auto-searched', 'autoSearch');
        });

        // Insights related routes
        Route::prefix('insights')->controller(InsightController::class)->group(function () {
            Route::get('/store-recent-view/{slug}','storeRecentView');
            Route::get('/get-recent-views','getRecentViews');
        });

         // Agents related routes
        Route::prefix('agents')->controller(AgentController::class)->group(function () {
            Route::get('','index');
            Route::get('/search','searchAgent');
        });

        // Agent related routes
        Route::prefix('agent')->controller(AgentController::class)->group(function () {
            Route::get('/{username}','show');
            Route::get('/reviews/{agentId}','showReviews');
        });


        // Agencies related routes
        Route::prefix('agencies')->controller(AgencyController::class)->group(function () {
            Route::get('','index');
            Route::get('/search','searchAgency');

        });

        // Agent related routes
        Route::prefix('agency')->controller(AgencyController::class)->group(function () {
            Route::get('/{username}','show');
            Route::get('/reviews/{agencyId}','showReviews');
            Route::get('/{user:username}/properties','getAllAgencyProperties');
        });

        // App/Teams related route
        Route::get('/teams', [TeamController::class,'getAppTeamsDemo01']);
    });

    Route::prefix('settings')->controller(SettingController::class)->group(function () {
        Route::get('/get-logo', 'getLogo');
        Route::get('/get-banner', 'getBanner');
        Route::get('/social-media', 'getSocialMedia');
    });

    /* ---------------- User's Dashboard routes (with auth) --------------- */
    Route::middleware('auth:sanctum')->group(function () {
        // User-related routes
        Route::controller(AuthController::class)->group(function () {
            Route::get('/user', 'getUser');
            Route::post('/logout', 'logout');
            Route::post('/change-password', 'changePassword');
            Route::delete('/delete-account', 'deleteAccount');
        });

        // Settings related routes
        Route::prefix('settings')->controller(SettingController::class)->group(function () {
            // Route::get('get-logo','getLogo');
            Route::post('update-logo','updateLogo');
            // Route::get('get-banner','getBanner');
            Route::post('update-banner','updateBanner');
            // Route::get('social-media','getSocialMedia');
            Route::post('update-social-media','updateSocialMedia');
            Route::get('/site-information', 'getSiteInformation');
            Route::post('/update-site-information', 'updateSiteInformation');
            Route::get('/stripe','getStripeSettings');
            Route::post('/update-stripe','updateStripeSettings');
            Route::get('/contact','getContactSettings');
            Route::post('/update-contact','updateContactSettings');
            Route::get('/email','getEmailSettings');
            Route::post('/update-email','updateEmailSettings');
            Route::get('/seo','getSeoSettings');
            Route::post('/update-seo','updateSeoSettings');
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
                Route::get('/change-status/{property}/{status}', 'changeStatus')->middleware('isAdmin');
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
            Route::post('/store-or-remove', 'storeOrRemoveSearch');
            Route::get('/is-saved', 'isSearchSaved');
            Route::post('/delete/{id}', 'destroy');
        });

        // Tour-requests related routes
        Route::prefix('tour-requests')->controller(TourRequestController::class)->group(function () {
            Route::get('/show', 'showUserMessages');
            Route::post('/send', 'sendMessage');
            Route::post('/delete/{message}', 'deleteUserMessage');
            Route::get('/details/{message}', 'showUserMessageDetail');
            Route::post('/reply', 'replyToMessage');
            Route::get('/{id}/replies', 'getReplies');
        });

        // Review-system related route
        Route::post('/reviews/store', [ReviewController::class, 'store']);
        Route::post('/agent/reviews/store', [AgentController::class, 'store']);
        Route::post('/agency/reviews/store', [AgencyController::class, 'store']);

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

        // Deals related routes
        Route::prefix('deals')->controller(DealController::class)->group(function () {
            Route::get('/', 'index');
            Route::post('/', 'store');
            Route::get('/{id}', 'show');
            Route::put('/{id}', 'update');
            Route::delete('/{id}', 'destroy');

            Route::get('/group/active', 'active');
            Route::get('/group/won', 'won');
            Route::get('/group/lost', 'lost');
        });

        // Leads related routes
        Route::apiResource('leads', LeadController::class);

        // Enquiry related routes
        Route::prefix('enquiries')->controller(EnquiryController::class)->group(function () {
            Route::get('/', 'index');
            Route::post('/', 'store');
            Route::get('/{id}',  'show');
            Route::delete('/{id}', 'destroy');
        });

        // Activity related routes
        Route::prefix('activities')->controller(ActivityController::class)->group(function () {
            Route::get('/reviews', 'myReviews');
            Route::get('/leads-summary', 'getLeadsSummary');
            Route::get('/deals-summary', 'getDealsSummary');
            Route::get('/enquiries-summary', 'getEnquiriesSummary');
        });

        // Insights related routes
        Route::prefix('insights')->controller(InsightController::class)->group(function () {
            Route::get('/properties', 'getInsightProperties');
            Route::get('/get-property-views/{id}', 'getPropertyViews');
            Route::get('/get-property-unique-views/{id}', 'getPropertyUniqueViews');
            Route::get('/get-chart-stats/{property}', 'getChartStats');
            Route::get('/get-devices-stats/{property}', 'getDeviceStats');
            Route::get('/get-countries-stats/{property}', 'getCountriesStats');
            Route::get('/get-platform-stats/{property}', 'getPlatformStats');
            Route::get('/get-browser-stats/{property}', 'getBrowsersStats');
        });

        // Admin related routes
        Route::middleware('isAdmin')->group(function () {
            // All-Users related routes
            Route::controller(UsersController::class)->group(function () {
                Route::get('/get-all-users',  'getAllUsers');
                Route::get('/get-all-agents',  'getAllAgents');
                Route::get('/get-agency-users','getAgencyUsers');
                Route::post('/delete-user/{user}',  'deleteUser');
                Route::post('/change-user-role/{user}/{role}',  'updateUserRole');
            });

            // Newsletter-Subscribe related routes
            Route::controller(NewsletterSubscribeController::class)->group(function () {
                Route::get('/get-all-subscribers',  'getAllSubscribers');
                Route::post('/delete-subscriber/{subscriber}', 'destroy');
            });

            // Blogs related routes
            Route::apiResource('blogs', BlogController::class);

            // Teams related routes
            Route::apiResource('teams', TeamController::class);
        });
    });
});
