<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('agency_agent', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agency_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            $table->foreignId('agent_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            $table->timestamps();

            // Prevent duplicate entries
            $table->unique(['agency_id', 'agent_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agency_agent');
    }
};
