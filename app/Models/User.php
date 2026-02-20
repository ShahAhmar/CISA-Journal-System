<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotification;
use App\Notifications\ResetPasswordNotification as CustomResetPasswordNotification;

use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'phone',
        'affiliation',
        'orcid',
        'bio',
        'profile_image',
        'role',
        'is_active',
        'notify_system',
        'notify_marketing',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
            'notify_system' => 'boolean',
            'notify_marketing' => 'boolean',
        ];
    }

    public function journals()
    {
        return $this->belongsToMany(Journal::class, 'journal_users')
            ->withPivot('role', 'section', 'is_active')
            ->withTimestamps();
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'reviewer_id');
    }

    public function assignedSubmissions()
    {
        return $this->hasMany(Submission::class, 'assigned_editor_id');
    }

    public function sectionSubmissions()
    {
        return $this->hasMany(Submission::class, 'section_editor_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function hasJournalRole($journalId, $role)
    {
        $query = $this->journals()
            ->where('journals.id', $journalId)
            ->wherePivot('is_active', true);

        // Support both single role and array of roles
        if (is_array($role)) {
            $query->wherePivotIn('role', $role);
        } else {
            $query->wherePivot('role', $role);
        }

        return $query->exists();
    }

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new CustomResetPasswordNotification($token));
    }
}

