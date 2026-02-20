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
        Schema::table('submissions', function (Blueprint $table) {
            $table->enum('copyedit_approval_status', ['pending', 'approved', 'changes_requested'])->nullable()->after('current_stage');
            $table->text('copyedit_author_comments')->nullable()->after('copyedit_approval_status');
            $table->timestamp('copyedit_approved_at')->nullable()->after('copyedit_author_comments');
            $table->foreignId('copyedit_approved_by')->nullable()->after('copyedit_approved_at')->constrained('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('submissions', function (Blueprint $table) {
            $table->dropForeign(['copyedit_approved_by']);
            $table->dropColumn(['copyedit_approval_status', 'copyedit_author_comments', 'copyedit_approved_at', 'copyedit_approved_by']);
        });
    }
};
