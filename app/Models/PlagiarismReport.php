<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlagiarismReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'submission_id',
        'similarity_percentage',
        'matched_submissions',
        'highlighted_matches',
        'status',
        'error_message',
    ];

    protected $casts = [
        'matched_submissions' => 'array',
        'highlighted_matches' => 'array',
    ];

    public function submission()
    {
        return $this->belongsTo(Submission::class);
    }
}
