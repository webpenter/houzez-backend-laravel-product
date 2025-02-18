<?php

namespace App\Providers;

use App\Repositories\AppPropertyRepositoryInterface;
use App\Repositories\Eloquent\AppPropertyRepository;
use App\Repositories\Eloquent\PropertyAttachmentRepository;
use App\Repositories\Eloquent\PropertyImageRepository;
use App\Repositories\Eloquent\PropertyRepository;
use App\Repositories\PropertyAttachmentRepositoryInterface;
use App\Repositories\PropertyImageRepositoryInterface;
use App\Repositories\PropertyRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(PropertyRepositoryInterface::class, PropertyRepository::class);
        $this->app->bind(PropertyImageRepositoryInterface::class, PropertyImageRepository::class);
        $this->app->bind(PropertyAttachmentRepositoryInterface::class, PropertyAttachmentRepository::class);
        $this->app->bind(AppPropertyRepositoryInterface::class, AppPropertyRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
