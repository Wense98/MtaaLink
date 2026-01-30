<?php

namespace App\Http\Controllers;

use App\Models\Request as ServiceRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class ServiceRequestController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $worker_id): RedirectResponse
    {
        $worker = User::findOrFail($worker_id);

        if ($worker->role !== User::ROLE_WORKER) {
            abort(404);
        }

        if (Auth::id() === $worker->id) {
            return back()->withErrors(['error' => 'You cannot request service from yourself.']);
        }

        $request->validate([
            'message' => ['required', 'string', 'max:1000'],
            'requested_date' => ['nullable', 'date', 'after_or_equal:today'],
            'request_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        $data = [
            'user_id' => Auth::id(),
            'worker_id' => $worker->id,
            'message' => $request->message,
            'status' => 'pending',
            'requested_date' => $request->requested_date,
        ];

        if ($request->hasFile('request_image')) {
            $data['image_path'] = $request->file('request_image')->store('requests', 'public');
        }

        $newRequest = ServiceRequest::create($data);

        // Notify the worker
        $worker->notify(new \App\Notifications\NewServiceRequestNotification($newRequest));

        return back()->with('status', 'request-sent');
    }

    /**
     * Update the status of a request (Accept/Reject/Complete).
     */
    public function updateStatus(Request $request, $id)
    {
        $serviceRequest = ServiceRequest::findOrFail($id);
        
        // Ensure the auth user is the worker receiving the request
        if (Auth::id() !== $serviceRequest->worker_id) {
            abort(403);
        }

        $request->validate([
            'status' => ['required', 'in:accepted,rejected,completed'],
            'price_estimate' => ['nullable', 'numeric', 'min:0'],
            'worker_notes' => ['nullable', 'string', 'max:500'],
        ]);

        $updateData = ['status' => $request->status];
        
        if ($request->filled('price_estimate')) {
            $updateData['price_estimate'] = $request->price_estimate;
            $updateData['worker_notes'] = $request->worker_notes;
            $updateData['quoted_at'] = now();
        }

        $serviceRequest->update($updateData);

        // Notify the customer
        $serviceRequest->user->notify(new \App\Notifications\RequestStatusUpdatedNotification($serviceRequest));

        return back()->with('status', 'request-updated');
    }

    /**
     * Customer accepts the price estimate/quote.
     */
    public function acceptQuote($id)
    {
        $serviceRequest = ServiceRequest::findOrFail($id);

        if (Auth::id() !== $serviceRequest->user_id) {
            abort(403);
        }

        if ($serviceRequest->status !== 'accepted' || !$serviceRequest->price_estimate) {
            return back()->withErrors(['error' => 'No active quote found to accept.']);
        }

        // We could add a 'quote_accepted' status or just a flag
        // For now, let's just mark it as confirmed in the session or a new column
        // But status 'accepted' is already enough if the UI shows the quote.
        
        return back()->with([
            'status' => 'quote-accepted',
            'request_id' => $id
        ]);
    }
}
