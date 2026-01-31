<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of all transactions.
     */
    public function index()
    {
        $transactions = Transaction::with(['user', 'worker', 'request'])
            ->latest()
            ->paginate(20);

        return view('admin.transactions.index', compact('transactions'));
    }

    /**
     * Display a list of disputed transactions.
     */
    public function disputes()
    {
        $transactions = Transaction::with(['user', 'worker', 'request'])
            ->whereNotNull('disputed_at')
            ->latest()
            ->paginate(20);

        return view('admin.transactions.index', compact('transactions'))
            ->with('filter', 'disputed');
    }

    /**
     * Resolve a dispute (Admin Intervention)
     */
    public function resolve(Request $httpRequest, Transaction $transaction)
    {
        $httpRequest->validate([
            'action' => 'required|in:release,refund',
            'admin_note' => 'required|string|min:5',
        ]);

        if ($httpRequest->action === 'release') {
            $transaction->update(['status' => 'released']);
            $statusMsg = 'Funds released to worker.';
        } else {
            $transaction->update(['status' => 'refunded']);
            $statusMsg = 'Funds refunded to customer.';
        }

        // We could log the admin_note in a separate log table or activity log.
        
        return back()->with('status', 'Dispute resolved: ' . $statusMsg);
    }
}
