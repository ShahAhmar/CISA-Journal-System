<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    use HasFactory;

    protected $fillable = [
        'journal_id',
        'user_id',
        'title',
        'abstract',
        'keywords',
        'supporting_agencies',
        'requirements_accepted',
        'privacy_accepted',
        'journal_section_id',
        'status',
        'current_stage',
        'assigned_editor_id',
        'section_editor_id',
        'section',
        'editor_notes',
        'author_comments',
        'doi',
        'page_start',
        'page_end',
        'issue_id',
        'submitted_at',
        'published_at',
        'copyedit_approval_status',
        'copyedit_author_comments',
        'copyedit_approved_at',
        'copyedit_approved_by',
    ];

    protected function casts(): array
    {
        return [
            'submitted_at' => 'datetime',
            'published_at' => 'datetime',
            'requirements_accepted' => 'boolean',
            'privacy_accepted' => 'boolean',
        ];
    }

    public function journal()
    {
        return $this->belongsTo(Journal::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function assignedEditor()
    {
        return $this->belongsTo(User::class, 'assigned_editor_id');
    }

    public function sectionEditor()
    {
        return $this->belongsTo(User::class, 'section_editor_id');
    }

    public function issue()
    {
        return $this->belongsTo(Issue::class);
    }

    public function files()
    {
        return $this->hasMany(SubmissionFile::class);
    }

    public function authors()
    {
        return $this->hasMany(SubmissionAuthor::class)->orderBy('order');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function logs()
    {
        return $this->hasMany(SubmissionLog::class)->orderBy('created_at', 'desc');
    }

    public function discussionThreads()
    {
        return $this->hasMany(DiscussionThread::class);
    }

    public function galleys()
    {
        return $this->hasMany(Galley::class);
    }

    public function references()
    {
        return $this->hasMany(Reference::class)->orderBy('order');
    }

    public function journalSection()
    {
        return $this->belongsTo(JournalSection::class, 'journal_section_id');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function analytics()
    {
        return $this->hasMany(ArticleAnalytic::class);
    }

    public function getViewsCountAttribute()
    {
        return $this->analytics()->where('event_type', 'view')->count();
    }

    public function getDownloadsCountAttribute()
    {
        return $this->analytics()->where('event_type', 'download')->count();
    }

    public function getManuscriptAttribute()
    {
        return $this->files()->where('file_type', 'manuscript')->latest()->first();
    }

    protected function formatDateSafe($value, string $format): ?string
    {
        if (!$value) {
            return null;
        }

        try {
            if (is_string($value)) {
                return \Carbon\Carbon::parse($value)->format($format);
            }

            if (method_exists($value, 'format')) {
                return $value->format($format);
            }

            return \Carbon\Carbon::parse($value)->format($format);
        } catch (\Exception $e) {
            return date($format, strtotime($value));
        }
    }

    /**
     * Safely format submitted_at regardless of storage type (string/Carbon)
     */
    public function formatSubmittedAt(string $format = 'M d, Y'): ?string
    {
        return $this->formatDateSafe($this->submitted_at, $format);
    }

    public function getFormattedSubmittedAtAttribute(): ?string
    {
        return $this->formatSubmittedAt();
    }

    /**
     * Safely format published_at regardless of storage type
     */
    public function formatPublishedAt(string $format = 'M d, Y'): ?string
    {
        return $this->formatDateSafe($this->published_at, $format);
    }

    public function getFormattedPublishedAtAttribute(): ?string
    {
        return $this->formatPublishedAt();
    }
}

