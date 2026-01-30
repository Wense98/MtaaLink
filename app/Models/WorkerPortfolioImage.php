<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkerPortfolioImage extends Model
{
    use HasFactory;

    protected $fillable = ['worker_profile_id', 'image_path', 'description'];

    public function workerProfile()
    {
        return $this->belongsTo(WorkerProfile::class);
    }
}
