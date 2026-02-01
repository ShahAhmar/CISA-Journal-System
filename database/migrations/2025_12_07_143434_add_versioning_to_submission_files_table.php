<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('submission_files', function (Blueprint $table) {
            // File versioning (version column already exists, only add new fields)
            if (!Schema::hasColumn('submission_files', 'version_label')) {
                $table->string('version_label')->nullable()->after('version'); // e.g., "Initial", "Revised", "Final"
            }
            if (!Schema::hasColumn('submission_files', 'parent_file_id')) {
                $table->foreignId('parent_file_id')->nullable()->after('version_label')
                    ->constrained('submission_files')->onDelete('set null'); // Link to previous version
            }
            if (!Schema::hasColumn('submission_files', 'version_notes')) {
                $table->text('version_notes')->nullable()->after('parent_file_id'); // Notes about this version
            }
            if (!Schema::hasColumn('submission_files', 'is_current')) {
                $table->boolean('is_current')->default(true)->after('version_notes'); // Current version flag
            }
        });
    }

    public function down(): void
    {
        Schema::table('submission_files', function (Blueprint $table) {
            $table->dropForeign(['parent_file_id']);
            $table->dropColumn([
                'version',
                'version_label',
                'parent_file_id',
                'version_notes',
                'is_current',
            ]);
        });
    }
};
