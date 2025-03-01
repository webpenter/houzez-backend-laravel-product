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
        Schema::create('general_settings', function (Blueprint $table) {
            $table->id();
            //site details
            $table->string('site_logo')->nullable();
            $table->string('site_name')->nullable();
            $table->string('site_title')->nullable();
            $table->text('site_description')->nullable();
            $table->text('site_address')->nullable();
            
            $table->string('contact_number')->nullable();
            $table->string('email_address')->nullable();

            // socail links
            $table->string('facebook_link')->nullable();
            $table->string('instagram_link')->nullable();
            $table->string('twitter_link')->nullable();
            $table->string('linkedin_link')->nullable();

            $table->string('hero_title')->nullable();
            $table->text('hero_description')->nullable();
            $table->string('hero_section_image')->nullable();
            $table->string('new_user_default_role')->nullable();
            $table->string('site_language')->nullable();
            $table->text('footer_description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('general_settings');
    }
};
