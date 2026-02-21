<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
    'name',
    'nim',
    'jurusan',
    'semester',
    'gender',
    'age',
    'email',
    'password',
    'status',
    'verification_token',
    'email_reminder_enabled',
    'last_reminder_sent_at',
    'login_streak',
    'last_login_date',
];



    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function assessments()
{
    return $this->hasMany(StressAssessment::class);
}

public function notifications()
{
    return $this->hasMany(Notification::class)->orderBy('created_at', 'desc');
}

public function unreadNotifications()
{
    return $this->hasMany(Notification::class)->where('is_read', false);
}

public function getUnreadNotificationCountAttribute()
{
    return $this->notifications()->where('is_read', false)->count();
}

/**
 * Badges earned by this user
 */
public function badges()
{
    return $this->belongsToMany(Badge::class, 'user_badges')
                ->withPivot('earned_at')
                ->withTimestamps();
}

/**
 * Feedback submitted by this user
 */
public function feedback()
{
    return $this->hasMany(Feedback::class);
}

/**
 * Get total badge points for this user
 */
public function getTotalBadgePointsAttribute()
{
    return $this->badges()->sum('points');
}

/**
 * Check if user has a specific badge
 */
public function hasBadge($badgeSlug)
{
    return $this->badges()->where('slug', $badgeSlug)->exists();
}

/**
 * Send the password reset notification.
 *
 * @param  string  $token
 * @return void
 */
public function sendPasswordResetNotification($token)
{
    $this->notify(new \App\Notifications\ResetPasswordNotification($token, $this->email));
}

/**
 * Send the email verification notification.
 *
 * @return void
 */
public function sendEmailVerificationNotification()
{
    $this->notify(new \App\Notifications\VerifyEmailNotification);
}

}
