<?php

namespace App\Providers;

use App\Models\Property;
use App\Models\Setting;
use App\Observers\Property\PropertyObserver;
use App\Repositories\ActivityRepositoryInterface;
use App\Repositories\AppPropertyRepositoryInterface;
use App\Repositories\DealRepositoryInterface;
use App\Repositories\Eloquent\ActivityRepository;
use App\Repositories\Eloquent\AppPropertyRepository;
use App\Repositories\Eloquent\DealRepository;
use App\Repositories\Eloquent\EnquiryRepository;
use App\Repositories\Eloquent\FavoritePropertyRepository;
use App\Repositories\Eloquent\InsightRepository;
use App\Repositories\Eloquent\LeadRepository;
use App\Repositories\Eloquent\PropertyAttachmentRepository;
use App\Repositories\Eloquent\PropertyImageRepository;
use App\Repositories\Eloquent\PropertyRepository;
use App\Repositories\Eloquent\ReviewRepository;
use App\Repositories\Eloquent\StripePlanRepository;
use App\Repositories\Eloquent\StripeSubscriptionRepository;
use App\Repositories\Eloquent\TeamRepository;
use App\Repositories\Eloquent\TourRequestRepository;
use App\Repositories\Eloquent\UsersRepository;
use App\Repositories\Eloquent\AgentRepository;
use App\Repositories\Eloquent\AgencyRepository;
use App\Repositories\EnquiryRepositoryInterface;
use App\Repositories\FavoritePropertyRepositoryInterface;
use App\Repositories\InsightRepositoryInterface;
use App\Repositories\LeadRepositoryInterface;
use App\Repositories\PropertyAttachmentRepositoryInterface;
use App\Repositories\PropertyImageRepositoryInterface;
use App\Repositories\PropertyRepositoryInterface;
use App\Repositories\ReviewRepositoryInterface;
use App\Repositories\StripePlanRepositoryInterface;
use App\Repositories\StripeSubscriptionRepositoryInterface;
use App\Repositories\TeamRepositoryInterface;
use App\Repositories\TourRequestRepositoryInterface;
use App\Repositories\UsersRepositoryInterface;
use App\Repositories\AgentRepositoryInterface;
use App\Repositories\AgencyRepositoryInterface;
use App\Repositories\Eloquent\SettingRepository;
use App\Repositories\SettingRepositoryInterface;
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

        // Team-system repositories binding
        $this->app->bind(TeamRepositoryInterface::class, TeamRepository::class);

        // Insight repositories binding
        $this->app->bind(InsightRepositoryInterface::class, InsightRepository::class);

        // Board repositories binding
        $this->app->bind(ActivityRepositoryInterface::class, ActivityRepository::class);
        $this->app->bind(DealRepositoryInterface::class, DealRepository::class);
        $this->app->bind(LeadRepositoryInterface::class, LeadRepository::class);
        $this->app->bind(EnquiryRepositoryInterface::class, EnquiryRepository::class);

        // Agent & Agency repositories binding
        $this->app->bind(AgentRepositoryInterface::class, AgentRepository::class);
        $this->app->bind(AgencyRepositoryInterface::class, AgencyRepository::class);

        // Settings repositories
        // Settings repository binding
        $this->app->bind(SettingRepositoryInterface::class, function ($app) {
            return new SettingRepository($app->make(Setting::class));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Property::observe(PropertyObserver::class);
    }
}
