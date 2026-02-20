<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('submission_id')->constrained()->onDelete('cascade');
            $table->foreignId('reviewer_id')->constrained('users')->onDelete('cascade');
            $table->string('status')->default('pending'); // pending, submitted, declined
            $table->text('recommendation')->nullable(); // accept, minor_revision, major_revision, reject
            $table->text('comments_for_editor')->nullable();
            $table->text('comments_for_author')->nullable();
            $table->date('assigned_date');
            $table->date('due_date');
            $table->date('submitted_date')->nullable();
            $table->text('decline_reason')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};

