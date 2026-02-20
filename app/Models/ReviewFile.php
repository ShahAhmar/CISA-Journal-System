<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'review_id',
        'file_name',
        'file_path',
        'file_type',
        'original_name',
        'mime_type',
        'file_size',
    ];

    public function review()
    {
        return $this->belongsTo(Review::class);
    }
}

