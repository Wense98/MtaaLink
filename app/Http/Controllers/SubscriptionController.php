<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function create()
    {
        // Show a simple subscription form (plan selection)
        return view('subscriptions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'plan' => ['required', 'in:monthly,yearly'],
        ]);

        $user = $request->user();
        if (! $user) {
            abort(403);
        }

        // Stub: in a real app you would integrate M-Pesa / TigoPesa here and verify payment
        $starts = now();
        $ends = $request->plan === 'monthly' ? now()->addMonth() : now()->addYear();

        $sub = Subscription::create([
            'user_id' => $user->id,
            'plan' => $request->plan,
            'price' => $request->plan === 'monthly' ? 5000 : 55000,
            'starts_at' => $starts,
            'ends_at' => $ends,
            'active' => true,
        ]);

        return redirect()->route('dashboard')->with('status', 'Subscription created (dev stub).');
    }
}