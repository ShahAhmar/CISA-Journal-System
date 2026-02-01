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
        Schema::table('journal_page_settings', function (Blueprint $table) {
            $table->longText('content_html')->nullable()->after('is_enabled');
            $table->longText('content_css')->nullable()->after('content_html');
            $table->json('grapesjs_data')->nullable()->after('content_css');
        });
    }

    public function down(): void
    {
        Schema::table('journal_page_settings', function (Blueprint $table) {
            $table->dropColumn(['content_html', 'content_css', 'grapesjs_data']);
        });
    }
};
