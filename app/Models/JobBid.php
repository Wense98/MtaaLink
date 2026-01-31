<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobBid extends Model
{
    protected $fillable = [
        'public_job_id', 'worker_id', 'amount', 'message', 'estimated_duration', 'status'
    ];

    public function job()
    {
        return $this->belongsTo(PublicJob::class, 'public_job_id');
    }

    public function worker()
    {
        return $this->belongsTo(User::class, 'worker_id');
    }
}
