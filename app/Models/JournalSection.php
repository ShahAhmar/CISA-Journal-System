<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class JournalSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'journal_id',
        'title',
        'slug',
        'description',
        'section_editor_id',
        'word_limit_min',
        'word_limit_max',
        'review_type',
        'order',
        'is_active',
        'settings',
    ];

    protected function casts(): array
    {
        return [
            'settings' => 'array',
            'is_active' => 'boolean',
        ];
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($section) {
            if (empty($section->slug)) {
                $section->slug = Str::slug($section->title);
            }
        });
    }

    public function journal()
    {
        return $this->belongsTo(Journal::class);
    }

    public function sectionEditor()
    {
        return $this->belongsTo(User::class, 'section_editor_id');
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class, 'section', 'title');
    }
}

