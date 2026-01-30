<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\WorkerProfile;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Redirect; // Add this import

class WorkerProfileController extends Controller
{
    /**
     * Display the worker profile edit form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();

        // Ensure user is a worker
        if ($user->role !== \App\Models\User::ROLE_WORKER) {
            abort(403, 'Only workers can edit a worker profile.');
        }

        // Get or create profile
        $profile = $user->workerProfile ?? WorkerProfile::create(['user_id' => $user->id]);
        
        $services = Service::orderBy('name')->get();

        return view('worker.edit', [
            'user' => $user,
            'profile' => $profile,
            'services' => $services,
        ]);
    }

    /**
     * Update the worker profile.
     */
    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        // Ensure user is a worker
        if ($user->role !== \App\Models\User::ROLE_WORKER) {
            abort(403);
        }

        $validated = $request->validate([
            'service_id' => ['required', 'exists:services,id'],
            'bio' => ['nullable', 'string', 'max:1000'],
            'skills' => ['nullable', 'string', 'max:255'],
            'experience_years' => ['required', 'integer', 'min:0', 'max:50'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'region' => ['required', 'string', 'max:255'],
            'district' => ['required', 'string', 'max:255'],
            'ward' => ['required', 'string', 'max:255'],
            'street' => ['required', 'string', 'max:255'],
            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],
        ]);

        $profile = $user->workerProfile;

        // Ensure profile exists (it should)
        if (!$profile) {
            $profile = WorkerProfile::create(['user_id' => $user->id]);
        }

        $profile->update($validated);

        // Handle Portfolio Images
        if ($request->hasFile('portfolio_images')) {
            foreach ($request->file('portfolio_images') as $image) {
                $path = $image->store('portfolio', 'public');
                $profile->portfolioImages()->create([
                    'image_path' => $path
                ]);
            }
        }

        return Redirect::route('dashboard')->with('status', 'profile-updated');
    }

    public function destroyPortfolioImage(Request $request, $id): RedirectResponse
    {
        $image = \App\Models\WorkerPortfolioImage::findOrFail($id);
        
        // Authorization check
        if ($image->workerProfile->user_id !== $request->user()->id) {
            abort(403);
        }

        // Delete from storage (optional, good practice)
        // \Illuminate\Support\Facades\Storage::disk('public')->delete($image->image_path);

        $image->delete();

        return back()->with('status', 'image-deleted');
    }

    /**
     * Display the specified worker profile.
     */
    public function show($id): View
    {
        $user = \App\Models\User::with(['workerProfile.service', 'receivedReviews.user'])->findOrFail($id);
        
        if ($user->role !== \App\Models\User::ROLE_WORKER) {
            abort(404);
        }

        // Increment views count via the profile relationship
        if ($user->workerProfile) {
            $user->workerProfile->increment('views_count');
        }

        $ratingBreakdown = [
            5 => $user->receivedReviews->where('rating', 5)->count(),
            4 => $user->receivedReviews->where('rating', 4)->count(),
            3 => $user->receivedReviews->where('rating', 3)->count(),
            2 => $user->receivedReviews->where('rating', 2)->count(),
            1 => $user->receivedReviews->where('rating', 1)->count(),
        ];

        return view('worker.show', compact('user', 'ratingBreakdown'));
    }
    public function updateAvailability(Request $request): RedirectResponse
    {
        $profile = $request->user()->workerProfile;
        
        if (!$profile) {
            abort(404);
        }

        $profile->update([
            'is_available' => !$profile->is_available
        ]);

        return back()->with('status', 'availability-updated');
    }
}

