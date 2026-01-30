<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'worker_id',
        'rating',
        'comment',
        'image_path',
        'reply',
        'replied_at',
    ];

    protected $casts = [
        'replied_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id'); // Reviewer
    }

    public function worker()
    {
        return $this->belongsTo(User::class, 'worker_id'); // Reviewee
    }
}
