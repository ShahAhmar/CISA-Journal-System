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
            $table->text('supporting_agencies')->nullable()->after('keywords');
            $table->boolean('requirements_accepted')->default(false)->after('supporting_agencies');
            $table->boolean('privacy_accepted')->default(false)->after('requirements_accepted');
            $table->foreignId('journal_section_id')->nullable()->after('section')->constrained('journal_sections')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('submissions', function (Blueprint $table) {
            $table->dropForeign(['journal_section_id']);
            $table->dropColumn(['supporting_agencies', 'requirements_accepted', 'privacy_accepted', 'journal_section_id']);
        });
    }
};
