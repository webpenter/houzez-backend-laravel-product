<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();

            // Step-1 (title,description,price)
            $table->string('title');
            $table->string('description')->nullable();
            $table->string('type')->nullable();
            $table->string('status')->default('draft');
            $table->string('label')->nullable();
            $table->decimal('price', 10, 2);
            $table->decimal('second_price', 10, 2)->nullable();
            $table->string('after_price')->nullable();
            $table->string('price_prefix')->nullable();

            //  Step-2 (property-details)
            $table->integer('bedrooms')->nullable();
            $table->integer('bathrooms')->nullable();
            $table->integer('garages')->nullable();
            $table->string('garages_size')->nullable();
            $table->integer('area_size');
            $table->string('size_prefix')->nullable();
            $table->integer('land_area')->nullable();
            $table->string('land_area_size_postfix')->nullable();
            $table->string('property_id')->nullable();
            $table->integer('year_built')->nullable();

            //  Step-3 (property-features)
            $table->json('property_feature')->nullable();

            //  Step-4 (energy-class)
            $table->string('energy_class')->nullable();
            $table->string('global_energy_performance_index')->nullable();
            $table->string('renewable_energy_performance_index')->nullable();
            $table->string('energy_performance_of_the_building')->nullable();

            //  Step-5 (location,map)
            $table->string('address');
            $table->string('country')->nullable();
            $table->string('county_state')->nullable();
            $table->string('city')->nullable();
            $table->string('neighborhood')->nullable();
            $table->string('zip_postal_code')->nullable();
            $table->text('map_street_view')->nullable();
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);

            //  Step-6 (video_url)
            $table->string('video_url')->nullable();

            // Step-7 (virtual_tour)
            $table->text('virtual_tour')->nullable();

            // Step-10 (contact-information)
            $table->json('contact_information')->nullable();

            // Step-12 (private-note)
            $table->text('private_note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
