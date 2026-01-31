<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'description',
    ];

    public function workerProfiles()
    {
        return $this->hasMany(WorkerProfile::class);
    }

    public function publicJobs()
    {
        return $this->hasMany(PublicJob::class);
    }
}
