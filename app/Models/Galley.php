<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Galley extends Model
{
    use HasFactory;

    protected $fillable = [
        'submission_id',
        'type',
        'label',
        'file_path',
        'original_name',
        'mime_type',
        'file_size',
        'approval_status',
        'author_comments',
        'approved_at',
        'approved_by',
        'uploaded_by',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
        'file_size' => 'integer',
    ];

    public function submission()
    {
        return $this->belongsTo(Submission::class);
    }

    public function uploadedBy()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
