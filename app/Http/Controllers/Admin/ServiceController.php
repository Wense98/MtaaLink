<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ServiceController extends Controller
{


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = Service::withCount('workerProfiles')->orderBy('name')->paginate(10);
        return view('admin.services.index', compact('services'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:services,name',
            'description' => 'nullable|string|max:500',
        ]);

        Service::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
        ]);

        return back()->with('status', 'Service created successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        if ($service->workerProfiles()->count() > 0) {
            return back()->withErrors(['error' => 'Cannot delete service, it is assigned to workers.']);
        }

        $service->delete();

        return back()->with('status', 'Service deleted successfully!');
    }
}
