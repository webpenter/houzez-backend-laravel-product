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
         Schema::create('settings', function (Blueprint $table) {
            $table->id();

            // Setting key (unique identifier)
            $table->string('key')->unique();

            // Value (can be string, json, text depending on type)
            $table->text('value')->nullable();

            // Type (for frontend usage: text, image, url, boolean, etc.)
            $table->string('type')->default('string');

            // Visibility toggle (show/hide)
            $table->boolean('is_visible')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
