<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'journal_id',
        'submission_id',
        'user_id',
        'type',
        'amount',
        'currency',
        'status',
        'payment_method',
        'transaction_id',
        'payment_details',
        'proof_file',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'payment_details' => 'array',
    ];

    public function journal()
    {
        return $this->belongsTo(Journal::class);
    }

    public function submission()
    {
        return $this->belongsTo(Submission::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

