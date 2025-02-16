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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('plan_id');
            $table->string('name');
            $table->string('billing_method');
            $table->tinyInteger('interval_count')->default(1);
            $table->string('price');
            $table->string('currency');
            $table->string('number_of_listings')->nullable();
            $table->string('number_of_images')->nullable();
            $table->string('taxes')->nullable();
            $table->string('total_price')->nullable();
            $table->boolean('active')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
