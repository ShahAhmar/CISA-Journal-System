<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('journals', function (Blueprint $table) {
            $table->json('homepage_widgets')->nullable()->after('homepage_content'); // Homepage widget layout
            $table->json('page_builder_settings')->nullable()->after('homepage_widgets'); // Builder settings
        });
    }

    public function down(): void
    {
        Schema::table('journals', function (Blueprint $table) {
            $table->dropColumn(['homepage_widgets', 'page_builder_settings']);
        });
    }
};

