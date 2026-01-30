<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\VerificationRequest;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class VerificationController extends Controller
{
    /**
     * Show the verification application form for workers.
     */
    public function create()
    {
        $user = auth()->user();
        if ($user->role !== User::ROLE_WORKER) {
            return redirect()->route('dashboard')->with('error', 'Only workers can apply for verification.');
        }

        $existingRequest = VerificationRequest::where('user_id', $user->id)->latest()->first();

        return view('verification.create', compact('existingRequest'));
    }

    /**
     * Store the verification request.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_type' => 'required|string|in:NIDA,Passport,Voter ID,Driving License',
            'id_number' => 'required|string|max:50',
            'document' => 'required|file|image|max:5120', // Max 5MB image
        ]);

        $user = auth()->user();

        // Check for pending request
        if (VerificationRequest::where('user_id', $user->id)->where('status', 'pending')->exists()) {
            return back()->with('error', 'You already have a pending verification request.');
        }

        $path = $request->file('document')->store('verification_documents', 'public');

        VerificationRequest::create([
            'user_id' => $user->id,
            'id_type' => $request->id_type,
            'id_number' => $request->id_number,
            'document_path' => $path,
            'status' => 'pending',
        ]);

        return redirect()->route('dashboard')->with('success', 'Your verification request has been submitted and is under review.');
    }

    /**
     * Admin view: list all pending verification requests.
     */
    public function index()
    {
        if (auth()->user()->role !== User::ROLE_ADMIN) {
            abort(403);
        }

        $requests = VerificationRequest::with('user.workerProfile.service')
            ->where('status', 'pending')
            ->latest()
            ->paginate(10);

        return view('admin.verification.index', compact('requests'));
    }

    /**
     * Admin action: Approve or reject a request.
     */
    public function update(Request $request, $id)
    {
        if (auth()->user()->role !== User::ROLE_ADMIN) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:approved,rejected',
            'rejection_reason' => 'required_if:status,rejected|nullable|string|max:500',
        ]);

        $verification = VerificationRequest::findOrFail($id);
        $user = $verification->user;

        $verification->update([
            'status' => $request->status,
            'rejection_reason' => $request->rejection_reason,
        ]);

        if ($request->status === 'approved') {
            $user->update(['is_verified' => true]);
            $message = "Congratulations! Your account has been verified.";
        } else {
            $user->update(['is_verified' => false]);
            $message = "Your verification request was rejected. Reason: " . $request->rejection_reason;
        }

        // Notify user if possible (assuming notification system exists)
        // \App\Models\Notification::create([...]); 
        
        return back()->with('success', 'Verification request updated successfully.');
    }
}
