<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'submission_id',
        'reviewer_id',
        'previous_review_id',
        'revision_round',
        'status',
        'recommendation',
        'comments_for_editor',
        'comments_for_author',
        'comments_for_editors', // New: Separate comments for editors only
        'comments_for_authors', // New: Separate comments for authors only
        'assigned_date',
        'due_date',
        'submitted_date',
        'reviewed_at',
        'decline_reason',
        'reviewer_rating',
        'reviewer_expertise',
        'review_time_days',
        'review_history',
    ];

    protected $casts = [
        'assigned_date' => 'datetime',
        'due_date' => 'datetime',
        'submitted_date' => 'datetime',
        'reviewed_at' => 'datetime',
        'reviewer_expertise' => 'array',
        'review_history' => 'array',
    ];

    public function submission()
    {
        return $this->belongsTo(Submission::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }

    public function files()
    {
        return $this->hasMany(ReviewFile::class);
    }

    public function previousReview()
    {
        return $this->belongsTo(Review::class, 'previous_review_id');
    }

    public function revisionReviews()
    {
        return $this->hasMany(Review::class, 'previous_review_id');
    }
}

