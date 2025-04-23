<?php

namespace App\Providers;

use App\Repositories\AppPropertyRepositoryInterface;
use App\Repositories\Eloquent\AppPropertyRepository;
use App\Repositories\Eloquent\FavoritePropertyRepository;
use App\Repositories\Eloquent\PropertyAttachmentRepository;
use App\Repositories\Eloquent\PropertyImageRepository;
use App\Repositories\Eloquent\PropertyRepository;
use App\Repositories\Eloquent\ReviewRepository;
use App\Repositories\Eloquent\StripePlanRepository;
use App\Repositories\Eloquent\StripeSubscriptionRepository;
use App\Repositories\Eloquent\TourRequestRepository;
use App\Repositories\Eloquent\UsersRepository;
use App\Repositories\Eloquent\GeneralSettingRepository;
use App\Repositories\Eloquent\NavbarButtonRepository;

use App\Repositories\FavoritePropertyRepositoryInterface;
use App\Repositories\GeneralSettingRepositoryInterface;
use App\Repositories\NavbarButtonRepositoryInterface;
use App\Repositories\PropertyAttachmentRepositoryInterface;
use App\Repositories\PropertyImageRepositoryInterface;
use App\Repositories\PropertyRepositoryInterface;
use App\Repositories\ReviewRepositoryInterface;
use App\Repositories\StripePlanRepositoryInterface;
use App\Repositories\StripeSubscriptionRepositoryInterface;
use App\Repositories\TourRequestRepositoryInterface;
use App\Repositories\UsersRepositoryInterface;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Auth repositories binding
        $this->app->bind(UsersRepositoryInterface::class, UsersRepository::class);

        // Property repositories binding
        $this->app->bind(PropertyRepositoryInterface::class, PropertyRepository::class);
        $this->app->bind(PropertyImageRepositoryInterface::class, PropertyImageRepository::class);
        $this->app->bind(PropertyAttachmentRepositoryInterface::class, PropertyAttachmentRepository::class);
        $this->app->bind(AppPropertyRepositoryInterface::class, AppPropertyRepository::class);
        $this->app->bind(FavoritePropertyRepositoryInterface::class, FavoritePropertyRepository::class);

        // Stripe-payments repositories binding
        $this->app->bind(StripePlanRepositoryInterface::class, StripePlanRepository::class);
        $this->app->bind(StripeSubscriptionRepositoryInterface::class, StripeSubscriptionRepository::class);

        // Tour-requests repositories binding
        $this->app->bind(TourRequestRepositoryInterface::class, TourRequestRepository::class);

        // Reviews-system repositories binding
        $this->app->bind(ReviewRepositoryInterface::class, ReviewRepository::class);

        // General Settings repositories binding
        $this->app->bind(GeneralSettingRepositoryInterface::class, GeneralSettingRepository::class);

        $this->app->bind(NavbarButtonRepositoryInterface::class, NavbarButtonRepository::class);
    
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
