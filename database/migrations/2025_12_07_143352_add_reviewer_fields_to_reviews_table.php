<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            // Reviewer rating and expertise
            $table->integer('reviewer_rating')->nullable()->after('recommendation'); // 1-5 rating
            $table->json('reviewer_expertise')->nullable()->after('reviewer_rating'); // Areas of expertise
            $table->text('comments_for_editors')->nullable()->after('comments_for_author'); // Comments only for editors (separate from existing)
            $table->text('comments_for_authors')->nullable()->after('comments_for_editors'); // Comments for authors (separate from existing)
            $table->timestamp('reviewed_at')->nullable()->after('submitted_date'); // Review completion timestamp
            $table->integer('review_time_days')->nullable()->after('reviewed_at'); // Days taken to review
            $table->json('review_history')->nullable()->after('review_time_days'); // Review history log
        });
    }

    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropColumn([
                'reviewer_rating',
                'reviewer_expertise',
                'comments_for_editors',
                'comments_for_authors',
                'review_time_days',
                'review_history',
            ]);
        });
    }
};
