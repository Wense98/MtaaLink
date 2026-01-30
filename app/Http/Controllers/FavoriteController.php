<?php

namespace App\Http\Controllers;

use App\Models\WorkerProfile;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    /**
     * Toggle favorite status for a worker.
     */
    public function toggle(Request $request, $worker_profile_id): RedirectResponse
    {
        $workerProfile = WorkerProfile::findOrFail($worker_profile_id);
        $user = Auth::user();

        // Check if already favorited
        if ($user->favorites()->where('worker_profile_id', $worker_profile_id)->exists()) {
            $user->favorites()->detach($worker_profile_id);
            $message = 'Removed from favorites.';
        } else {
            $user->favorites()->attach($worker_profile_id);
            $message = 'Added to favorites!';
        }

        return back()->with('status', $message);
    }
}
