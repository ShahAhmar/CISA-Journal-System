<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('journals', function (Blueprint $table) {
            // Basic Information
            $table->string('journal_initials')->nullable()->after('name');
            $table->string('journal_url')->nullable()->after('slug');
            $table->string('journal_abbreviation')->nullable()->after('journal_url');
            
            // Contact Information
            $table->string('primary_contact_name')->nullable()->after('contact_address');
            $table->string('primary_contact_email')->nullable()->after('primary_contact_name');
            $table->string('support_contact_name')->nullable()->after('primary_contact_email');
            $table->string('support_email')->nullable()->after('support_contact_name');
            
            // Policies & Guidelines
            $table->longText('peer_review_policy')->nullable()->after('peer_review_process');
            $table->text('copyright_notice')->nullable()->after('open_access_policy');
            $table->longText('privacy_statement')->nullable()->after('copyright_notice');
            
            // Editorial Team
            $table->text('editor_in_chief')->nullable()->after('editorial_team');
            $table->text('managing_editor')->nullable()->after('editor_in_chief');
            $table->longText('section_editors')->nullable()->after('managing_editor');
            $table->longText('editorial_board_members')->nullable()->after('section_editors');
            
            // Author Guidelines Extended
            $table->longText('submission_requirements')->nullable()->after('author_guidelines');
            $table->longText('submission_checklist')->nullable()->after('submission_requirements');
            $table->longText('competing_interest_statement')->nullable()->after('submission_checklist');
            $table->longText('copyright_agreement')->nullable()->after('competing_interest_statement');
            
            // Review Settings
            $table->integer('review_rounds')->default(2)->after('copyright_agreement');
            $table->string('review_method')->nullable()->after('review_rounds'); // double_blind, single_blind, open
            $table->text('review_forms')->nullable()->after('review_method');
            $table->json('email_templates')->nullable()->after('review_forms');
            
            // Issue & Article Settings
            $table->json('article_metadata_options')->nullable()->after('review_forms');
            $table->boolean('doi_enabled')->default(false)->after('doi_prefix');
            
            // Website Settings
            $table->string('favicon')->nullable()->after('cover_image');
            $table->longText('homepage_content')->nullable()->after('theme');
            $table->text('footer_content')->nullable()->after('homepage_content');
            $table->json('navigation_menu')->nullable()->after('footer_content');
            $table->json('color_scheme')->nullable()->after('navigation_menu');
            $table->json('slider_blocks')->nullable()->after('color_scheme');
            
            // Indexing & Archive
            $table->json('indexing_metadata')->nullable()->after('slider_blocks');
            $table->json('archive_settings')->nullable()->after('indexing_metadata');
            
            // Payment & License
            $table->json('payment_settings')->nullable()->after('archive_settings');
            $table->string('license_type')->nullable()->after('payment_settings'); // CC BY, CC BY-NC, etc.
            
            // Language & Regional
            $table->string('primary_language')->default('en')->after('license_type');
            $table->json('additional_languages')->nullable()->after('primary_language');
            $table->string('timezone')->nullable()->after('additional_languages');
            $table->string('date_format')->nullable()->after('timezone');
            
            // File Upload Settings
            $table->json('allowed_formats')->nullable()->after('date_format');
            $table->integer('max_file_size')->default(10)->after('allowed_formats'); // in MB
            $table->boolean('plagiarism_check_required')->default(false)->after('max_file_size');
        });
    }

    public function down(): void
    {
        Schema::table('journals', function (Blueprint $table) {
            $table->dropColumn([
                'journal_initials',
                'journal_url',
                'journal_abbreviation',
                'primary_contact_name',
                'primary_contact_email',
                'support_contact_name',
                'support_email',
                'peer_review_policy',
                'copyright_notice',
                'privacy_statement',
                'editor_in_chief',
                'managing_editor',
                'section_editors',
                'editorial_board_members',
                'submission_requirements',
                'submission_checklist',
                'competing_interest_statement',
                'copyright_agreement',
                'review_rounds',
                'review_method',
                'review_forms',
                'email_templates',
                'article_metadata_options',
                'doi_enabled',
                'favicon',
                'homepage_content',
                'footer_content',
                'navigation_menu',
                'color_scheme',
                'slider_blocks',
                'indexing_metadata',
                'archive_settings',
                'payment_settings',
                'license_type',
                'primary_language',
                'additional_languages',
                'timezone',
                'date_format',
                'allowed_formats',
                'max_file_size',
                'plagiarism_check_required',
            ]);
        });
    }
};
