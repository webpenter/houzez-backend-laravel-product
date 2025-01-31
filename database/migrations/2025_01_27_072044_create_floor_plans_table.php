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
        Schema::create('floor_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained('properties')->onDelete('cascade');
            $table->string('plan_title')->nullable();
            $table->integer('plan_bedrooms')->nullable();
            $table->integer('plan_bathrooms')->nullable();
            $table->decimal('plan_price', 10, 2)->nullable();
            $table->string('price_postfix')->nullable();
            $table->integer('plan_size')->nullable();
            $table->string('plan_image')->nullable();
            $table->string('plan_description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('floor_plans');
    }
};
