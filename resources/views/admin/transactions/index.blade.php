@extends('layouts.app')

@section('title', 'System Transactions')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-3xl p-8 border border-gray-100 dark:border-gray-700">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h2 class="text-2xl font-black text-gray-900 dark:text-gray-100 italic">
                        {{ isset($filter) && $filter === 'disputed' ? 'Disputed Transactions' : 'All Transactions' }}
                    </h2>
                    <p class="text-sm text-gray-500">Managed platform financial records and custody.</p>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('admin.transactions.index') }}" class="px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-widest {{ !isset($filter) ? 'bg-gray-900 text-white' : 'bg-gray-100 text-gray-600' }}">All</a>
                    <a href="{{ route('admin.transactions.disputes') }}" class="px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-widest {{ isset($filter) && $filter === 'disputed' ? 'bg-red-600 text-white' : 'bg-red-50 text-red-600' }}">Disputes</a>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-100 dark:divide-gray-700">
                    <thead>
                        <tr class="text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">
                            <th class="pb-4">Reference</th>
                            <th class="pb-4">Customer</th>
                            <th class="pb-4">Worker</th>
                            <th class="pb-4">Amount</th>
                            <th class="pb-4">Status</th>
                            <th class="pb-4">Date</th>
                            <th class="pb-4 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 dark:divide-gray-700">
                        @forelse($transactions as $tx)
                            <tr class="group hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                                <td class="py-4">
                                    <span class="font-mono text-xs font-bold text-gray-900 dark:text-gray-100">{{ $tx->reference }}</span>
                                    @if($tx->isDisputed())
                                        <span class="block text-[8px] text-red-600 font-black uppercase">Disputed</span>
                                    @endif
                                </td>
                                <td class="py-4">
                                    <div class="text-xs font-bold text-gray-900 dark:text-gray-100">{{ $tx->user->name }}</div>
                                    <div class="text-[9px] text-gray-400">{{ $tx->user->email }}</div>
                                </td>
                                <td class="py-4">
                                    <div class="text-xs font-bold text-gray-900 dark:text-gray-100">{{ $tx->worker->name }}</div>
                                    <div class="text-[9px] text-gray-400">{{ $tx->worker->email }}</div>
                                </td>
                                <td class="py-4">
                                    <div class="text-xs font-black text-gray-900 dark:text-gray-100">TZS {{ number_format($tx->amount) }}</div>
                                    <div class="text-[9px] text-gray-400 uppercase tracking-tighter">{{ $tx->payment_method }}</div>
                                </td>
                                <td class="py-4">
                                    <span class="px-2 py-0.5 rounded-full text-[9px] font-black uppercase tracking-widest
                                        {{ $tx->status === 'held' ? 'bg-amber-100 text-amber-800' : '' }}
                                        {{ $tx->status === 'released' ? 'bg-green-100 text-green-800' : '' }}
                                        {{ $tx->status === 'refunded' ? 'bg-red-100 text-red-800' : '' }}">
                                        {{ $tx->status }}
                                    </span>
                                </td>
                                <td class="py-4 text-xs font-medium text-gray-500">
                                    {{ $tx->created_at->format('M d, Y') }}
                                </td>
                                <td class="py-4 text-right">
                                    @if($tx->isDisputed() && $tx->status === 'held')
                                        <div x-data="{ open: false }">
                                            <button @click="open = true" class="text-[10px] font-black text-indigo-600 hover:underline uppercase tracking-widest">Resolve</button>
                                            
                                            <!-- Resolve Modal -->
                                            <div x-show="open" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
                                                <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm" @click="open = false"></div>
                                                <div class="flex min-h-full items-center justify-center p-4">
                                                    <div class="relative bg-white dark:bg-gray-800 rounded-3xl p-8 max-w-md w-full text-left shadow-2xl border border-gray-100 dark:border-gray-700">
                                                        <h3 class="text-lg font-black text-gray-900 dark:text-gray-100 mb-2 italic">Resolve Dispute</h3>
                                                        <p class="text-xs text-gray-500 mb-6">Action: <strong>{{ $tx->dispute_reason }}</strong></p>
                                                        
                                                        <form action="{{ route('admin.transactions.resolve', $tx->id) }}" method="POST">
                                                            @csrf
                                                            <div class="mb-6">
                                                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Internal Note</label>
                                                                <textarea name="admin_note" rows="3" required class="w-full rounded-2xl border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 text-xs py-3 px-4" placeholder="Explain the rationale for this decision..."></textarea>
                                                            </div>
                                                            <div class="flex gap-4">
                                                                <button name="action" value="release" class="flex-1 py-3 bg-teal-600 text-white font-black rounded-2xl text-[10px] uppercase tracking-widest hover:bg-teal-700 transition-colors">Release to Worker</button>
                                                                <button name="action" value="refund" class="flex-1 py-3 bg-red-600 text-white font-black rounded-2xl text-[10px] uppercase tracking-widest hover:bg-red-700 transition-colors">Refund Customer</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-[10px] text-gray-300 font-bold uppercase tracking-widest italic">No Action</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-12 text-center text-sm text-gray-400 italic">No transactions found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-8">
                {{ $transactions->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
