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
        ]);

        $serviceRequest->update(['status' => $request->status]);

        // Notify the customer
        $serviceRequest->user->notify(new \App\Notifications\RequestStatusUpdatedNotification($serviceRequest));

        return back()->with('status', 'request-updated');
    }
}
