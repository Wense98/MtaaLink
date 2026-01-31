<?php

namespace App\Http\Controllers;

use App\Models\PublicJob;
use App\Models\JobBid;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PublicJobController extends Controller
{
    /**
     * List all open public jobs (Marketplace for Workers)
     */
    public function index(Request $request)
    {
        $query = PublicJob::with(['service', 'user'])->where('status', 'open')->latest();

        if ($request->filled('service_id')) {
            $query->where('service_id', $request->service_id);
        }

        if ($request->filled('region')) {
            $query->where('region', 'like', '%' . $request->region . '%');
        }

        $jobs = $query->paginate(10);
        $services = Service::orderBy('name')->get();

        return view('jobs.index', compact('jobs', 'services'));
    }

    /**
     * Show form to post a new job (For Customers)
     */
    public function create()
    {
        $services = Service::orderBy('name')->get();
        return view('jobs.create', compact('services'));
    }

    /**
     * Store a new public job
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'budget' => 'nullable|numeric|min:0',
            'region' => 'required|string|max:255',
            'district' => 'required|string|max:255',
            'ward' => 'required|string|max:255',
            'expires_at' => 'nullable|date|after:now',
        ]);

        $job = Auth::user()->publicJobs()->create($validated);

        return redirect()->route('jobs.my-jobs')->with('status', 'job-posted');
    }

    /**
     * Display job details
     */
    public function show(PublicJob $job)
    {
        $job->load(['service', 'user', 'bids.worker']);
        return view('jobs.show', compact('job'));
    }

    /**
     * List jobs posted by the current user
     */
    public function myJobs()
    {
        $jobs = Auth::user()->publicJobs()->with(['service', 'bids'])->latest()->get();
        return view('jobs.my-jobs', compact('jobs'));
    }

    /**
     * Worker submits a bid
     */
    public function bid(Request $request, PublicJob $job)
    {
        if (Auth::user()->role !== 'worker') {
            return back()->with('error', 'Only workers can bid on jobs.');
        }

        $validated = $request->validate([
            'amount' => 'required|numeric|min:0',
            'message' => 'required|string|max:1000',
            'estimated_duration' => 'nullable|string|max:255',
        ]);

        $bid = $job->bids()->create([
            'worker_id' => Auth::id(),
            'amount' => $validated['amount'],
            'message' => $validated['message'],
            'estimated_duration' => $validated['estimated_duration'] ?? null,
            'status' => 'pending'
        ]);

        // Notify the Job Owner
        $job->user->notify(new \App\Notifications\NewBidReceived($bid));

        return back()->with('status', 'bid-submitted');
    }

    /**
     * Customer accepts a bid
     */
    public function acceptBid(JobBid $bid)
    {
        $job = $bid->job;

        if (Auth::id() !== $job->user_id) {
            abort(403);
        }

        // Close job and accept bid
        $job->update(['status' => 'assigned']);
        $bid->update(['status' => 'accepted']);
        
        // Reject other bids
        $job->bids()->where('id', '!=', $bid->id)->update(['status' => 'rejected']);

        // Create a unified Request record so it appears in standard dashboards
        \App\Models\Request::create([
            'user_id' => $job->user_id,
            'worker_id' => $bid->worker_id,
            'message' => 'Marketplace Job: ' . $job->title,
            'status' => 'accepted', // Immediately active
            'price_estimate' => $bid->amount,
            'worker_notes' => "Bid Message: {$bid->message} (Duration: {$bid->estimated_duration})",
            'requested_date' => now(),
        ]);

        // Notify the Worker
        $bid->worker->notify(new \App\Notifications\BidAccepted($bid));

        return back()->with('status', 'bid-accepted');
    }
}
