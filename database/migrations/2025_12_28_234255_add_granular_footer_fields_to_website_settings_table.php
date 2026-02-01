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
        Schema::table('website_settings', function (Blueprint $table) {
            $table->text('footer_description')->nullable()->after('footer_text');
            $table->string('support_button_text')->nullable()->after('footer_description');
            $table->string('support_button_url')->nullable()->after('support_button_text');
            $table->string('footer_section_1_title')->default('Resources')->after('support_button_url');
            $table->string('footer_section_2_title')->default('Journals')->after('footer_section_1_title');
            $table->string('footer_section_3_title')->default('Contact')->after('footer_section_2_title');
            $table->json('footer_links')->nullable()->after('footer_section_3_title');
        });
    }

    public function down(): void
    {
        Schema::table('website_settings', function (Blueprint $table) {
            $table->dropColumn([
                'footer_description',
                'support_button_text',
                'support_button_url',
                'footer_section_1_title',
                'footer_section_2_title',
                'footer_section_3_title',
                'footer_links'
            ]);
        });
    }
};
