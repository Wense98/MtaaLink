<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\WorkerProfile;
use Illuminate\Http\Request;

class WorkerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // inline admin check to avoid kernel edits
        $this->middleware(function ($request, $next) {
            if (! $request->user() || $request->user()->role !== User::ROLE_ADMIN) {
                abort(403);
            }
            return $next($request);
        });
    }

    public function index()
    {
        $workers = User::where('role', User::ROLE_WORKER)->with('workerProfile')->paginate(20);
        return view('admin.workers.index', compact('workers'));
    }

    public function show($id)
    {
        $worker = User::where('role', User::ROLE_WORKER)->with('workerProfile')->findOrFail($id);
        return view('admin.workers.show', compact('worker'));
    }

    public function verify(Request $request, $id)
    {
        $worker = User::where('role', User::ROLE_WORKER)->findOrFail($id);
        $worker->is_verified = true;
        $worker->save();

        return back()->with('status', 'Worker verified');
    }

    public function unverify(Request $request, $id)
    {
        $worker = User::where('role', User::ROLE_WORKER)->findOrFail($id);
        $worker->is_verified = false;
        $worker->save();

        return back()->with('status', 'Worker unverified');
    }

    public function feature(Request $request, $id)
    {
        $worker = User::where('role', User::ROLE_WORKER)->findOrFail($id);
        if ($worker->workerProfile) {
            $worker->workerProfile->update(['is_featured' => true]);
        }
        return back()->with('status', 'Worker featured');
    }

    public function unfeature(Request $request, $id)
    {
        $worker = User::where('role', User::ROLE_WORKER)->findOrFail($id);
        if ($worker->workerProfile) {
            $worker->workerProfile->update(['is_featured' => false]);
        }
        return back()->with('status', 'Worker unfeatured');
    }
}
