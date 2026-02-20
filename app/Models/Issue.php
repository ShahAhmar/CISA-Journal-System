<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Issue extends Model
{
    use HasFactory;

    protected $fillable = [
        'journal_id',
        'volume',
        'issue_number',
        'year',
        'title',
        'description',
        'published_date',
        'is_published',
    ];

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName()
    {
        return 'id';
    }

    protected function casts(): array
    {
        return [
            'year' => 'integer',
            'published_date' => 'date',
            'is_published' => 'boolean',
        ];
    }

    public function journal()
    {
        return $this->belongsTo(Journal::class);
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }

    public function getDisplayTitleAttribute()
    {
        if ($this->title) {
            return $this->title;
        }
        
        $parts = [];
        if ($this->volume) {
            $parts[] = "Vol. {$this->volume}";
        }
        if ($this->issue_number) {
            $parts[] = "No. {$this->issue_number}";
        }
        if ($this->year) {
            $parts[] = $this->year;
        }
        
        return implode(', ', $parts) ?: "Issue #{$this->id}";
    }

    /**
     * Get formatted published date
     */
    public function getFormattedPublishedDateAttribute($format = 'M Y')
    {
        if (!$this->published_date) {
            return null;
        }

        try {
            if (is_string($this->published_date)) {
                return \Carbon\Carbon::parse($this->published_date)->format($format);
            }
            
            if (method_exists($this->published_date, 'format')) {
                return $this->published_date->format($format);
            }
            
            return \Carbon\Carbon::parse($this->published_date)->format($format);
        } catch (\Exception $e) {
            return date($format, strtotime($this->published_date));
        }
    }
}

