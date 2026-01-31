<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PublicJob;
use Illuminate\Http\Request;

class JobController extends Controller
{
    /**
     * Display a listing of public jobs.
     */
    public function index()
    {
        $jobs = PublicJob::with(['user', 'service', 'bids'])
            ->latest()
            ->paginate(15);
            
        return view('admin.jobs.index', compact('jobs'));
    }

    /**
     * Display the specified job.
     */
    public function show(PublicJob $job)
    {
        $job->load(['user', 'service', 'bids.worker']);
        return view('admin.jobs.show', compact('job'));
    }

    /**
     * Remove the specified job from storage.
     */
    public function destroy(PublicJob $job)
    {
        $job->delete();
        return back()->with('status', 'Job deleted successfully.');
    }
    
    /**
     * Manually close/cancel a job (Moderation)
     */
    public function close(PublicJob $job)
    {
        $job->update(['status' => 'cancelled']);
        return back()->with('status', 'Job marked as cancelled.');
    }
}
