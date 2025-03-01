<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $property_id
 * @property string|null $plan_title
 * @property int|null $plan_bedrooms
 * @property int|null $plan_bathrooms
 * @property string|null $plan_price
 * @property string|null $price_postfix
 * @property int|null $plan_size
 * @property string|null $plan_image
 * @property string|null $plan_description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FloorPlan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FloorPlan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FloorPlan query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FloorPlan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FloorPlan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FloorPlan wherePlanBathrooms($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FloorPlan wherePlanBedrooms($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FloorPlan wherePlanDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FloorPlan wherePlanImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FloorPlan wherePlanPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FloorPlan wherePlanSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FloorPlan wherePlanTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FloorPlan wherePricePostfix($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FloorPlan wherePropertyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FloorPlan whereUpdatedAt($value)
 */
	class FloorPlan extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $plan_id
 * @property string $name
 * @property string $billing_method
 * @property int $interval_count
 * @property string $price
 * @property string $currency
 * @property string|null $number_of_listings
 * @property string|null $number_of_images
 * @property string|null $taxes
 * @property string|null $total_price
 * @property int $active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Subscription> $subscriptions
 * @property-read int|null $subscriptions_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Plan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Plan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Plan query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Plan whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Plan whereBillingMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Plan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Plan whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Plan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Plan whereIntervalCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Plan whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Plan whereNumberOfImages($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Plan whereNumberOfListings($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Plan wherePlanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Plan wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Plan whereTaxes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Plan whereTotalPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Plan whereUpdatedAt($value)
 */
	class Plan extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string|null $description
 * @property string|null $type
 * @property string $status
 * @property string $property_status
 * @property bool $is_paid
 * @property bool $is_featured
 * @property string|null $label
 * @property numeric|null $price
 * @property numeric|null $second_price
 * @property string|null $after_price
 * @property string|null $price_prefix
 * @property int|null $bedrooms
 * @property int|null $bathrooms
 * @property int|null $garages
 * @property string|null $garages_size
 * @property int|null $area_size
 * @property string|null $size_prefix
 * @property int|null $land_area
 * @property string|null $land_area_size_postfix
 * @property string|null $property_id
 * @property int|null $year_built
 * @property array<array-key, mixed>|null $property_feature
 * @property string|null $energy_class
 * @property string|null $global_energy_performance_index
 * @property string|null $renewable_energy_performance_index
 * @property string|null $energy_performance_of_the_building
 * @property string|null $address
 * @property string|null $country
 * @property string|null $county_state
 * @property string|null $city
 * @property string|null $neighborhood
 * @property string|null $zip_postal_code
 * @property string|null $map_street_view
 * @property numeric|null $latitude
 * @property numeric|null $longitude
 * @property string|null $video_url
 * @property string|null $virtual_tour
 * @property array<array-key, mixed>|null $contact_information
 * @property string|null $private_note
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $user_id
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\FloorPlan> $floorPlans
 * @property-read int|null $floor_plans_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PropertyImage> $images
 * @property-read int|null $images_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SubProperty> $subProperties
 * @property-read int|null $sub_properties_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereAfterPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereAreaSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereBathrooms($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereBedrooms($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereContactInformation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereCountyState($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereEnergyClass($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereEnergyPerformanceOfTheBuilding($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereGarages($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereGaragesSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereGlobalEnergyPerformanceIndex($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereIsFeatured($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereIsPaid($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereLandArea($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereLandAreaSizePostfix($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereMapStreetView($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereNeighborhood($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property wherePricePrefix($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property wherePrivateNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property wherePropertyFeature($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property wherePropertyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property wherePropertyStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereRenewableEnergyPerformanceIndex($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereSecondPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereSizePrefix($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereVideoUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereVirtualTour($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereYearBuilt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Property whereZipPostalCode($value)
 */
	class Property extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $property_id
 * @property string $file_title
 * @property string $file_path
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Property $property
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PropertyAttachment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PropertyAttachment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PropertyAttachment query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PropertyAttachment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PropertyAttachment whereFilePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PropertyAttachment whereFileTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PropertyAttachment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PropertyAttachment wherePropertyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PropertyAttachment whereUpdatedAt($value)
 */
	class PropertyAttachment extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $property_id
 * @property string $image_path
 * @property int $is_thumbnail
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Property $property
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PropertyImage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PropertyImage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PropertyImage query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PropertyImage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PropertyImage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PropertyImage whereImagePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PropertyImage whereIsThumbnail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PropertyImage wherePropertyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PropertyImage whereUpdatedAt($value)
 */
	class PropertyImage extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $property_id
 * @property string|null $title
 * @property int|null $bedrooms
 * @property int|null $bathrooms
 * @property int|null $garages
 * @property string|null $garage_size
 * @property int|null $area_size
 * @property string|null $size_prefix
 * @property string|null $price
 * @property string|null $price_label
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Property $property
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubProperty newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubProperty newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubProperty query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubProperty whereAreaSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubProperty whereBathrooms($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubProperty whereBedrooms($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubProperty whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubProperty whereGarageSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubProperty whereGarages($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubProperty whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubProperty wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubProperty wherePriceLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubProperty wherePropertyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubProperty whereSizePrefix($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubProperty whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SubProperty whereUpdatedAt($value)
 */
	class SubProperty extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $user_id
 * @property string $type
 * @property string $stripe_id
 * @property string $stripe_status
 * @property string|null $stripe_price
 * @property int|null $quantity
 * @property \Illuminate\Support\Carbon|null $trial_ends_at
 * @property \Illuminate\Support\Carbon|null $ends_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Cashier\SubscriptionItem> $items
 * @property-read int|null $items_count
 * @property-read \App\Models\User|null $owner
 * @property-read \App\Models\Plan|null $plan
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subscription active()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subscription canceled()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subscription ended()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subscription expiredTrial()
 * @method static \Laravel\Cashier\Database\Factories\SubscriptionFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subscription incomplete()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subscription newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subscription newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subscription notCanceled()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subscription notOnGracePeriod()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subscription notOnTrial()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subscription onGracePeriod()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subscription onTrial()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subscription pastDue()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subscription query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subscription recurring()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subscription whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subscription whereEndsAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subscription whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subscription whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subscription whereStripeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subscription whereStripePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subscription whereStripeStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subscription whereTrialEndsAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subscription whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subscription whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Subscription whereUserId($value)
 */
	class Subscription extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $username
 * @property string|null $name
 * @property string $email
 * @property bool $is_admin
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $stripe_id
 * @property string|null $pm_type
 * @property string|null $pm_last_four
 * @property string|null $trial_ends_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \App\Models\UserProfile|null $profile
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Property> $properties
 * @property-read int|null $properties_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Cashier\Subscription> $subscriptions
 * @property-read int|null $subscriptions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @property-read \Laravel\Cashier\Subscription|null $userSubscription
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User hasExpiredGenericTrial()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User onGenericTrial()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereIsAdmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePmLastFour($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePmType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereStripeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereTrialEndsAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUsername($value)
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $public_name
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string|null $title
 * @property string|null $position
 * @property string|null $license
 * @property string|null $mobile
 * @property string|null $whatsapp
 * @property string|null $phone
 * @property string|null $fax_number
 * @property string|null $company_name
 * @property string|null $address
 * @property string|null $tax_number
 * @property string|null $service_areas
 * @property string|null $specialties
 * @property string|null $about_me
 * @property string|null $profile_picture
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $facebook
 * @property string|null $twitter
 * @property string|null $linkedin
 * @property string|null $instagram
 * @property string|null $google_plus
 * @property string|null $youtube
 * @property string|null $pinterest
 * @property string|null $vimeo
 * @property string|null $skype
 * @property string|null $website
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserProfile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserProfile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserProfile query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserProfile whereAboutMe($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserProfile whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserProfile whereCompanyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserProfile whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserProfile whereFacebook($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserProfile whereFaxNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserProfile whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserProfile whereGooglePlus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserProfile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserProfile whereInstagram($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserProfile whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserProfile whereLicense($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserProfile whereLinkedin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserProfile whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserProfile wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserProfile wherePinterest($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserProfile wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserProfile whereProfilePicture($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserProfile wherePublicName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserProfile whereServiceAreas($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserProfile whereSkype($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserProfile whereSpecialties($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserProfile whereTaxNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserProfile whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserProfile whereTwitter($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserProfile whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserProfile whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserProfile whereVimeo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserProfile whereWebsite($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserProfile whereWhatsapp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserProfile whereYoutube($value)
 */
	class UserProfile extends \Eloquent {}
}

