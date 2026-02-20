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
        Schema::table('reviews', function (Blueprint $table) {
            $table->foreignId('previous_review_id')->nullable()->after('reviewer_id')->constrained('reviews')->onDelete('set null');
            $table->integer('revision_round')->default(1)->after('previous_review_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropForeign(['previous_review_id']);
            $table->dropColumn(['previous_review_id', 'revision_round']);
        });
    }
};
