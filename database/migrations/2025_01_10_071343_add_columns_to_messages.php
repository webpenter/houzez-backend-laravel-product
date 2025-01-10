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
        Schema::table('messages', function (Blueprint $table) {
            // $table->unsignedBigInteger('sender_id')->nullable(); // Ensure data type matches
            // $table->foreign('sender_id')->references('id')->on('users')->onDelete('set null');
            // if (!Schema::hasColumn('messages', 'sender_id')) {
            //     $table->unsignedBigInteger('sender_id')->nullable();
            //     $table->foreign('sender_id')->references('id')->on('users')->onDelete('set null');
            // }

            // Add other columns if they don't exist
            if (!Schema::hasColumn('messages', 'sender_id')) {
                $table->foreignId('sender_id')->nullable()->constrained('users')->onDelete('cascade');
            }

            // if (!Schema::hasColumn('messages', 'group_id')) {
            //     $table->foreignId('group_id')->nullable()->constrained('groups')->onDelete('cascade');
            // }

            // if (!Schema::hasColumn('messages', 'is_read')) {
            //     $table->boolean('is_read')->default(false);
            // }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            //
        });
    }
};
