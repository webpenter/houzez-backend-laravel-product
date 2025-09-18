<?php

namespace App\Observers\Property;

use App\Models\Property;
use Illuminate\Support\Facades\Cache;

class PropertyObserver
{
    /**
     * Handle the Property "created" event.
     */
    public function created(Property $property): void
    {
        // Cache::tags('properties')->flush();
    }

    /**
     * Handle the Property "updated" event.
     */
    public function updated(Property $property): void
    {
        // Cache::tags('properties')->flush();
    }

    /**
     * Handle the Property "deleted" event.
     */
    public function deleted(Property $property): void
    {
        // Cache::tags('properties')->flush();
    }

    /**
     * Handle the Property "restored" event.
     */
    public function restored(Property $property): void
    {
        // Cache::tags('properties')->flush();
    }

    /**
     * Handle the Property "force deleted" event.
     */
    public function forceDeleted(Property $property): void
    {
        // Cache::tags('properties')->flush();
    }
}
