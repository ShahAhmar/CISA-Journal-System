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
        Schema::table('journals', function (Blueprint $table) {
            if (!Schema::hasColumn('journals', 'vision')) {
                $table->longText('vision')->nullable();
            }
            if (!Schema::hasColumn('journals', 'mission')) {
                $table->longText('mission')->nullable();
            }
            if (!Schema::hasColumn('journals', 'ethics_policy')) {
                $table->longText('ethics_policy')->nullable();
            }
            if (!Schema::hasColumn('journals', 'apc_policy')) {
                $table->longText('apc_policy')->nullable();
            }
            if (!Schema::hasColumn('journals', 'call_for_papers')) {
                $table->longText('call_for_papers')->nullable();
            }
            if (!Schema::hasColumn('journals', 'homepage_content')) {
                $table->longText('homepage_content')->nullable();
            }
            if (!Schema::hasColumn('journals', 'editorial_board_members')) {
                $table->longText('editorial_board_members')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('journals', function (Blueprint $table) {
            // We can't safely drop columns without knowing if they were added by this migration
            // But usually we drop them if we roll back.
            // For safety in this messy state, we might skip drop or drop if exists.

            $columns = ['vision', 'mission', 'ethics_policy', 'apc_policy', 'call_for_papers', 'homepage_content'];
            foreach ($columns as $column) {
                if (Schema::hasColumn('journals', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
