<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscussionThread extends Model
{
    use HasFactory;

    protected $fillable = [
        'submission_id',
        'title',
        'description',
        'is_locked',
    ];

    protected $casts = [
        'is_locked' => 'boolean',
    ];

    public function submission()
    {
        return $this->belongsTo(Submission::class);
    }

    public function comments()
    {
        return $this->hasMany(DiscussionComment::class, 'thread_id')->orderBy('created_at', 'asc');
    }

    public function latestComment()
    {
        return $this->hasOne(DiscussionComment::class, 'thread_id')->latestOfMany();
    }
}
