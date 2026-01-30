<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkerProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'service_id', 'bio', 'skills', 'experience_years', 'price',
        'region', 'district', 'ward', 'street', 'latitude', 'longitude', 'id_document', 'police_clearance', 'is_featured', 'is_available', 'views_count'
    ];

    protected $casts = [
        'is_featured' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
    
    public function portfolioImages()
    {
        return $this->hasMany(WorkerPortfolioImage::class);
    }

    public function getAchievements()
    {
        $badges = [];
        
        // Verified Pro
        if ($this->user->is_verified) {
            $badges[] = [
                'name' => 'Mtaa Verified',
                'description' => 'ID Identity confirmed by MtaaLink',
                'icon' => 'verified',
                'color' => 'teal'
            ];
        }

        // Ratings Badge
        $avgRating = $this->user->receivedReviews()->avg('rating');
        if ($avgRating >= 4.5 && $this->user->receivedReviews()->count() >= 5) {
            $badges[] = [
                'name' => 'Community Favorite',
                'description' => 'Highly rated by local residents',
                'icon' => 'heart',
                'color' => 'red'
            ];
        }

        // Experience Badge
        if ($this->experience_years >= 10) {
            $badges[] = [
                'name' => 'Elite Experience',
                'description' => 'Over 10 years of professional work',
                'icon' => 'star',
                'color' => 'blue'
            ];
        }

        // Popularity Badge
        if ($this->views_count >= 100) {
            $badges[] = [
                'name' => 'Popular Pro',
                'description' => 'Gained high visibility in their mtaa',
                'icon' => 'fire',
                'color' => 'orange'
            ];
        }

        return $badges;
    }

    public function scopeVisible($query)
    {
        return $query->whereHas('user', function ($q) {
            $q->where('is_verified', true)
              ->where('role', \App\Models\User::ROLE_WORKER)
              ->where(function ($q2) {
                  $q2->whereHas('subscriptions', function ($s) {
                      $s->where('active', true)->where(function ($q3) {
                          $q3->whereNull('ends_at')->orWhere('ends_at', '>', now());
                      });
                  })->orWhereDoesntHave('subscriptions');
              });
        });
    }
}
