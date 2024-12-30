<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Foreign key for the user
            $table->string('public_name')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('title')->nullable();
            $table->string('position')->nullable();
            $table->string('license')->nullable();
            $table->string('mobile')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('phone')->nullable();
            $table->string('fax_number')->nullable();
            $table->string('company_name')->nullable();
            $table->string('address')->nullable();
            $table->string('tax_number')->nullable();
            $table->text('service_areas')->nullable(); // service areas field
            $table->text('specialties')->nullable(); // specialties field
            $table->text('about_me')->nullable(); // about me field
            $table->string('profile_picture')->nullable(); // profile picture field
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('user_profiles');
    }
};
