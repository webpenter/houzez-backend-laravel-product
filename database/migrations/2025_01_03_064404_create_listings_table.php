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
        Schema::create('listings', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description')->nullable();
            $table->string('type')->nullable();
            $table->string('status')->nullable();
            $table->string('labels')->nullable();
            $table->decimal('price', 10, 2);
            $table->decimal('second_price', 10, 2)->nullable();
            $table->string('after_price_label')->nullable();
            $table->string('price_prefix')->nullable();
            $table->text('custom_fields')->nullable();
            $table->integer('bedrooms');
            $table->integer('bathrooms');
            $table->integer('garages')->nullable();
            $table->string('garages_size')->nullable();
            $table->integer('area_size');
            $table->string('size_prefix')->nullable();
            $table->integer('land_area')->nullable();
            $table->string('land_area_size_postfix')->nullable();
            $table->string('user_id')->unique();
            $table->integer('year_built')->nullable();
            $table->json('additional_details')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('listings');
    }
};
