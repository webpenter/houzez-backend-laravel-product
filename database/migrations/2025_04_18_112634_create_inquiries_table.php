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
        Schema::create('inquiries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->string('inquiry_type')->default('purchase'); // purchase, sell, rent, miss, evaluation, mortgage
            $table->string('information_type')->default('I am a property owner'); // owner, agent, etc.

            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('mobile')->nullable();

            $table->string('location')->default('Downtown');
            $table->string('city')->default('New York');
            $table->string('area')->default('Manhattan');
            $table->string('state')->default('New York');
            $table->string('country')->default('USA');
            $table->string('zip_code')->default('10001');

            $table->string('property_type')->default('Single Family Home'); // Office, Lot, Villa, etc.
            $table->decimal('max_price', 15, 2)->nullable();
            $table->integer('min_size')->nullable();
            $table->integer('beds')->nullable();
            $table->integer('baths')->nullable();
            $table->text('message')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inquiries');
    }
};
