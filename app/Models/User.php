<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;
use App\Models\Subscription;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /**
     * Use Laravel model traits for API tokens, factory, notifications, and billing.
     *
     * - `HasApiTokens`: Enables API token authentication for the model.
     * - `HasFactory`: Allows the model to use a factory for testing and seeding.
     * - `Notifiable`: Adds notification support for the model.
     * - `Billable`: Enables Laravel Cashier billing functionalities.
     */
    use HasApiTokens, HasFactory, Notifiable, Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'is_admin',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
            'role' => 'string',
            'agency_id' => 'integer', // Cast agency_id to integer
        ];
    }

    /**
     * Check if the user has admin privileges.
     *
     * @return bool Returns true if the user is an admin, false otherwise.
     */
    public function isAdmin(): bool
    {
        return $this->is_admin;
    }

    /**
     * Generate a new Sanctum token.
     *
     * @return string
     */
    public function generateToken(): string
    {
        return $this->createToken('auth_token')->plainTextToken;
    }

    /**
     * Get the user's profile.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function profile(): HasOne
    {
        return $this->hasOne(UserProfile::class);
    }

    /**
     * Get the latest subscription for the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function userSubscription(): HasOne
    {
        return $this->hasOne(Subscription::class, 'user_id', 'id')->latest();
    }

    /**
     * Retrieve the properties associated with the current model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function properties(): HasMany
    {
        return $this->hasMany(Property::class);
    }

    /**
     * Determine if the user can create a property.
     *
     * A user can create a property if:
     * - They are an admin.
     * - They have an active subscription.
     * - They have not exceeded the listing limit of their plan.
     *
     * @return bool
     */
    public function canCreateProperty(): bool
    {
        if ($this->isAdmin()) {
            return true;
        }

        if ($this->userSubscription?->active()) {
            $currentPosts = $this->properties()->count();
            $postLimit = $this->userSubscription->plan->number_of_listings ?? 0;

            return $currentPosts < $postLimit;
        }

        return false;
    }

    public function inquiries()
    {
        return $this->hasMany(Inquiry::class);
    }


    public function assignedProperties()
    {
        return $this->belongsToMany(Property::class, 'property_agent', 'agent_id', 'property_id')->withTimestamps();
    }

    // Agencies that this user (agent) belongs to
    public function agencies()
    {
        return $this->belongsToMany(User::class, 'agency_agent', 'agent_id', 'agency_id');
    }

    // Agents that belong to this user (agency)
    public function agents()
    {
        return $this->belongsToMany(User::class, 'agency_agent', 'agency_id', 'agent_id');
    }

    public function agentReviews()
    {
        return $this->hasMany(AgentReview::class, 'agent_id');
    }

    public function agencyReviews()
    {
        return $this->hasMany(AgencyReview::class, 'agency_id');
    }
}
