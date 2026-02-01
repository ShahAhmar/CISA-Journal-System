<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubmissionContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'submission_id',
        'content',
        'processed_content',
    ];

    public function submission()
    {
        return $this->belongsTo(Submission::class);
    }
}
