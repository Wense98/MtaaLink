<?php

namespace App\Http\Controllers;

use App\Models\Request as ServiceRequest;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class WalletController extends Controller
{
    /**
     * Display Wallet Dashboard
     */
    public function index()
    {
        $user = Auth::user();
        
        $transactions = Transaction::where('user_id', $user->id)
            ->orWhere('worker_id', $user->id)
            ->latest()
            ->paginate(10);
            
        $pendingBalance = 0;
        $availableBalance = 0;
        
        if ($user->role === 'worker') {
            $pendingBalance = Transaction::where('worker_id', $user->id)->where('status', 'held')->sum('amount');
            $availableBalance = Transaction::where('worker_id', $user->id)->where('status', 'released')->sum('amount');
        }

        return view('wallet.index', compact('transactions', 'pendingBalance', 'availableBalance'));
    }

    /**
     * Show Payment Form for a Request
     */
    public function showPayment(ServiceRequest $request)
    {
        if (Auth::id() !== $request->user_id) {
            abort(403);
        }
        
        return view('wallet.pay', compact('request'));
    }

    /**
     * Process Payment (Simulation)
     */
    public function processPayment(Request $httpRequest, ServiceRequest $request)
    {
        if (Auth::id() !== $request->user_id) {
            abort(403);
        }
        
        $validated = $httpRequest->validate([
            'payment_method' => 'required|in:MPESA,TIGOPESA,AIRTEL,HALOPESA',
            'phone' => 'required|string',
        ]);
        
        // Simulate API Delay
        sleep(2);
        
        // Create Transaction
        Transaction::create([
            'user_id' => Auth::id(),
            'worker_id' => $request->worker_id,
            'request_id' => $request->id,
            'amount' => $request->price_estimate,
            'type' => 'payment',
            'status' => 'held', // Held in Escrow
            'payment_method' => $validated['payment_method'],
            'reference' => strtoupper(Str::random(10)),
        ]);
        
        return redirect()->route('wallet.index')->with('status', 'Payment successful! Funds held in secure escrow.');
    }
    
    /**
     * Release Funds (When Job Completed)
     */
    public function releaseFunds(ServiceRequest $request)
    {
        if (Auth::id() !== $request->user_id) {
            abort(403);
        }
        
        // Update Request Status
        $request->update(['status' => 'completed']);
        
        // Release funds
        Transaction::where('request_id', $request->id)
            ->where('status', 'held')
            ->update(['status' => 'released']);
            
        return back()->with('status', 'Job completed and funds released to worker!');
    }

    /**
     * Open a Dispute for a Transaction
     */
    public function openDispute(Request $httpRequest, Transaction $transaction)
    {
        if (Auth::id() !== $transaction->user_id) {
            abort(403);
        }

        if ($transaction->status !== 'held') {
            return back()->withErrors(['error' => 'Only payments in escrow can be disputed.']);
        }

        $validated = $httpRequest->validate([
            'reason' => 'required|string|min:10',
        ]);

        $transaction->update([
            'disputed_at' => now(),
            'dispute_reason' => $validated['reason'],
        ]);

        return back()->with('status', 'Dispute opened. MtaaLink team will review this transaction.');
    }
}
