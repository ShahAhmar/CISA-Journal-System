<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Journal extends Model
{
    use HasFactory;

    protected $fillable = [
        // Basic Information
        'name',
        'journal_initials',
        'slug',
        'journal_url',
        'journal_abbreviation',
        'authors',
        'description',
        'badge_text',

        // ISSN Information
        'issn',
        'print_issn',
        'online_issn',
        'impact_factor',

        // Contact Information
        'primary_contact_name',
        'primary_contact_email',
        'contact_phone',
        'contact_address',
        'support_contact_name',
        'support_email',

        // Content Sections
        'aims_scope',
        'focus_scope',
        'publication_frequency',
        'peer_review_process',
        'peer_review_policy',
        'open_access_policy',
        'copyright_notice',
        'privacy_statement',
        'vision',
        'mission',
        'ethics_policy',
        'apc_policy',
        'call_for_papers',

        // Editorial Team
        'editor_in_chief',
        'managing_editor',
        'section_editors',
        'editorial_board',
        'editorial_team',
        'editorial_board_members',

        // Author Guidelines
        'submission_guidelines',
        'author_guidelines',
        'submission_requirements',
        'submission_checklist',
        'competing_interest_statement',
        'copyright_agreement',

        // Review Settings
        'review_rounds',
        'review_method',
        'requires_review',
        'review_forms',
        'email_templates',

        // Issue & Article Settings
        'article_metadata_options',
        'doi_prefix',
        'doi_enabled',

        // Website Settings
        'logo',
        'cover_image',
        'favicon',
        'theme',
        'homepage_content',
        'homepage_widgets',
        'page_builder_settings',
        'footer_content',
        'navigation_menu',
        'color_scheme',
        'slider_blocks',

        // Indexing & Archive
        'indexing_metadata',
        'archive_settings',

        // Payment & License
        'payment_settings',
        'license_type',

        // Language & Regional
        'primary_language',
        'additional_languages',
        'timezone',
        'date_format',

        // File Upload Settings
        'allowed_formats',
        'max_file_size',
        'plagiarism_check_required',

        // Content Sections (Extended)
        'vision',
        'mission',
        'apc_policy',
        'ethics_policy',
        'partnerships_content',
        'call_for_papers',

        // System
        'settings',
        'is_active',
    ];

    public function getDescriptionExcerptAttribute()
    {
        return html_entity_decode(strip_tags(Str::limit($this->description, 200)));
    }

    protected $casts = [
        'settings' => 'array',
        'is_active' => 'boolean',
        'email_templates' => 'array',
        'article_metadata_options' => 'array',
        'navigation_menu' => 'array',
        'color_scheme' => 'array',
        'slider_blocks' => 'array',
        'homepage_widgets' => 'array',
        'page_builder_settings' => 'array',
        'indexing_metadata' => 'array',
        'archive_settings' => 'array',
        'payment_settings' => 'array',
        'additional_languages' => 'array',
        'allowed_formats' => 'array',
        'review_rounds' => 'integer',
        'max_file_size' => 'integer',
        'doi_enabled' => 'boolean',
        'plagiarism_check_required' => 'boolean',
        'impact_factor' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($journal) {
            if (empty($journal->slug)) {
                $journal->slug = Str::slug($journal->name);
            }
        });
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'journal_users')
            ->withPivot('role', 'section', 'is_active')
            ->withTimestamps();
    }

    public function issues()
    {
        return $this->hasMany(Issue::class);
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function managers()
    {
        return $this->users()->wherePivot('role', 'journal_manager');
    }

    public function editors()
    {
        return $this->users()->wherePivot('role', 'editor');
    }

    public function sectionEditors()
    {
        return $this->users()->wherePivot('role', 'section_editor');
    }

    public function reviewers()
    {
        return $this->users()
            ->wherePivot('role', 'reviewer')
            ->wherePivot('is_active', true);
    }

    public function sections()
    {
        return $this->hasMany(JournalSection::class)->orderBy('order');
    }

    public function activeSections()
    {
        return $this->sections()->where('is_active', true);
    }

    public function disciplines()
    {
        return $this->hasMany(JournalDiscipline::class)->orderBy('display_order');
    }

    public function pageSettings()
    {
        return $this->hasMany(JournalPageSetting::class)->orderBy('display_order');
    }

    public function partners()
    {
        return $this->hasMany(JournalPartner::class)->orderBy('display_order');
    }
}

