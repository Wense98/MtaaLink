<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'worker_id',
        'request_id',
        'amount',
        'type',
        'status',
        'payment_method',
        'reference',
        'disputed_at',
        'dispute_reason',
    ];

    public function isDisputed()
    {
        return !is_null($this->disputed_at);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function worker()
    {
        return $this->belongsTo(User::class, 'worker_id');
    }

    public function request()
    {
        return $this->belongsTo(Request::class);
    }
}
