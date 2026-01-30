<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Store a newly created review in storage.
     */
    public function store(Request $request, $worker_id): RedirectResponse
    {
        $worker = User::findOrFail($worker_id);

        if ($worker->role !== User::ROLE_WORKER) {
            abort(404);
        }

        if (Auth::id() === $worker->id) {
            return back()->withErrors(['error' => 'You cannot review yourself.']);
        }

        $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['nullable', 'string', 'max:500'],
            'review_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        $data = [
            'user_id' => Auth::id(),
            'worker_id' => $worker->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ];

        if ($request->hasFile('review_image')) {
            $data['image_path'] = $request->file('review_image')->store('reviews', 'public');
        }

        Review::create($data);

        return back()->with('status', 'review-submitted');
    }
}
