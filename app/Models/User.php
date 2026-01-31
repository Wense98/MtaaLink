<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    // Role constants
    public const ROLE_ADMIN = 'admin';
    public const ROLE_CUSTOMER = 'customer';
    public const ROLE_WORKER = 'worker';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'avatar',
        'is_verified',
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
            'phone_verified_at' => 'datetime',
            'is_verified' => 'boolean',
            'password' => 'hashed',
        ];
    }

    /**
     * Relationship: user -> worker profile (if user is a worker)
     */
    public function workerProfile()
    {
        return $this->hasOne(\App\Models\WorkerProfile::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(\App\Models\Subscription::class);
    }

    public function hasActiveSubscription(): bool
    {
        return $this->subscriptions()->where('active', true)->where(function ($q) {
            $q->whereNull('ends_at')->orWhere('ends_at', '>', now());
        })->exists();
    }

    public function receivedReviews()
    {
        return $this->hasMany(\App\Models\Review::class, 'worker_id');
    }

    public function sentRequests()
    {
        return $this->hasMany(\App\Models\Request::class, 'user_id'); // Requests sent by this user (customer)
    }

    public function receivedRequests()
    {
        return $this->hasMany(\App\Models\Request::class, 'worker_id'); // Requests received by this user (worker)
    }

    public function favorites()
    {
        return $this->belongsToMany(WorkerProfile::class, 'favorites', 'user_id', 'worker_profile_id')->withTimestamps();
    }

    public function publicJobs()
    {
        return $this->hasMany(PublicJob::class);
    }

    public function jobBids()
    {
        return $this->hasMany(JobBid::class, 'worker_id');
    }
}
