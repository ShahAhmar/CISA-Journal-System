<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'type',
        'journal_id',
        'is_published',
        'published_at',
        'send_email_notification',
        'scheduled_at',
        'emails_sent',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
        'scheduled_at' => 'datetime',
        'send_email_notification' => 'boolean',
        'emails_sent' => 'boolean',
    ];

    public function journal()
    {
        return $this->belongsTo(Journal::class);
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true)
            ->where(function ($q) {
                $q->whereNull('published_at')
                  ->orWhere('published_at', '<=', now());
            });
    }

    public function scopePlatformWide($query)
    {
        return $query->whereNull('journal_id');
    }

    public function scopeForJournal($query, $journalId)
    {
        return $query->where(function ($q) use ($journalId) {
            $q->whereNull('journal_id')
              ->orWhere('journal_id', $journalId);
        });
    }
}
