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
        Schema::create('emails', function (Blueprint $table) {
            $table->id();
            $table->foreignId('template_id')->nullable()->constrained('email_templates')->nullOnDelete();
            $table->text('to_email'); // JSON array
            $table->text('cc_email')->nullable(); // JSON
            $table->text('bcc_email')->nullable(); // JSON
            $table->string('subject');
            $table->longText('content');
            $table->enum('status', ['queued','sent','failed','draft'])->default('draft');
            $table->timestamp('sent_at')->nullable();
            $table->text('fail_reason')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emails');
    }
};
