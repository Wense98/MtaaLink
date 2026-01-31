<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PublicJob extends Model
{
    protected $fillable = [
        'user_id', 'service_id', 'title', 'description', 'budget',
        'region', 'district', 'ward', 'status', 'expires_at'
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function bids()
    {
        return $this->hasMany(JobBid::class);
    }
}
