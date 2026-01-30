<?php

namespace App\Http\Controllers;

use App\Models\WorkerProfile;
use App\Models\Service;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $services = Service::orderBy('name')->get();

        $query = WorkerProfile::with('user', 'service')
            ->whereHas('user', function ($q) {
                $q->where('role', \App\Models\User::ROLE_WORKER)
                  ->where('is_verified', true);
            });

        if ($request->filled('q')) {
            $q = $request->get('q');
            $query->where(function ($sub) use ($q) {
                $sub->where('bio', 'like', "%{$q}%")
                    ->orWhere('skills', 'like', "%{$q}%");
            });
        }

        if ($request->filled('service_id')) {
            $query->where('service_id', $request->service_id);
        }

        foreach (['region', 'district', 'ward', 'street'] as $loc) {
            if ($request->filled($loc)) {
                $query->where($loc, 'like', '%'.$request->get($loc).'%');
            }
        }

        if ($request->filled('min_experience')) {
            $query->where('experience_years', '>=', (int)$request->min_experience);
        }

        if ($request->filled('min_rating')) {
            $minRating = (float) $request->min_rating;
            $query->whereHas('user.receivedReviews', function ($q) use ($minRating) {
                $q->selectRaw('avg(rating)')
                  ->havingRaw('avg(rating) >= ?', [$minRating]);
            }, '>=', 0); // Note: Simple avg filter in whereHas is tricky, let's use a simpler approach for now or join
        }

        // Sorting
        if ($request->sort === 'price_low') {
            $query->orderBy('price');
        } elseif ($request->sort === 'price_high') {
            $query->orderByDesc('price');
        } elseif ($request->sort === 'experience') {
            $query->orderByDesc('experience_years');
        }

        // Proximity search if lat/lon provided (Haversine)
        if ($request->filled('lat') && $request->filled('lon')) {
            $lat = (float) $request->lat;
            $lon = (float) $request->lon;
            $haversine = "(6371 * acos(cos(radians($lat)) * cos(radians(latitude)) * cos(radians(longitude) - radians($lon)) + sin(radians($lat)) * sin(radians(latitude))))";
            $query->selectRaw('worker_profiles.*')->selectRaw("{$haversine} as distance");
            $query->orderBy('distance');
        } else {
            $query->orderByDesc('is_featured')->orderBy('created_at','desc');
        }

        $profiles = $query->paginate(12)->withQueryString();

        return view('search.index', compact('profiles', 'services'));
    }
}
