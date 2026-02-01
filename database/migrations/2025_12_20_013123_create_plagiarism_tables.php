<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('submission_contents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('submission_id')->constrained()->onDelete('cascade');
            $table->longText('content'); // Raw extracted text
            $table->longText('processed_content')->nullable(); // Pre-processed shingles/tokens
            $table->timestamps();
        });

        Schema::create('plagiarism_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('submission_id')->constrained()->onDelete('cascade');
            $table->float('similarity_percentage')->default(0);
            $table->json('matched_submissions')->nullable(); // List of [submission_id, percentage]
            $table->json('highlighted_matches')->nullable(); // List of [paragraph, match_source]
            $table->enum('status', ['pending', 'processing', 'completed', 'failed'])->default('pending');
            $table->text('error_message')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plagiarism_reports');
        Schema::dropIfExists('submission_contents');
    }
};
