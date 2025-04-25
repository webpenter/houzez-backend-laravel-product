<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInsightsTable extends Migration
{
    public function up()
    {
        Schema::create('insights', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained()->onDelete('cascade');
            $table->integer('views')->default(0);
            $table->integer('unique_views')->default(0);
            $table->integer('visits')->default(0);
            $table->json('devices')->nullable();   // Tracks device types (desktop, phone, tablet, etc.)
            $table->json('countries')->nullable(); // Tracks countries based on IP or user input
            $table->json('platforms')->nullable(); // Tracks platforms (Windows, MacOS, etc.)
            $table->json('browsers')->nullable();  // Tracks browsers (Chrome, Safari, etc.)
            $table->json('referrals')->nullable(); // Tracks referral URLs
            $table->timestamps(); // Timestamp fields for created_at and updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('insights');
    }
}
