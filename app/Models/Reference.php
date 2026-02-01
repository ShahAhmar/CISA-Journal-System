<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reference extends Model
{
    use HasFactory;

    protected $fillable = [
        'submission_id',
        'reference_text',
        'order',
    ];

    public function submission()
    {
        return $this->belongsTo(Submission::class);
    }
}

