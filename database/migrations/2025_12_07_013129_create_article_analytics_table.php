<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('article_analytics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('submission_id')->constrained()->onDelete('cascade');
            $table->foreignId('journal_id')->constrained()->onDelete('cascade');
            $table->string('event_type'); // 'view', 'download', 'citation'
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->string('referrer')->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->json('metadata')->nullable(); // Additional data
            $table->timestamp('created_at');
            
            // Indexes for performance
            $table->index(['submission_id', 'event_type', 'created_at']);
            $table->index(['journal_id', 'event_type', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('article_analytics');
    }
};
