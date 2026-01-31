<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Mtaa Wallet') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <!-- Balance Cards (Worker Only) -->
                @if(Auth::user()->role === 'worker')
                    <div class="bg-gradient-to-br from-indigo-500 to-indigo-700 rounded-3xl p-6 text-white shadow-lg">
                        <span class="text-xs font-bold uppercase tracking-widest opacity-80">Pending Balance (Escrow)</span>
                        <div class="text-4xl font-black mt-2">TZS {{ number_format($pendingBalance) }}</div>
                        <p class="text-xs opacity-70 mt-2">Held until job confirmation</p>
                    </div>
                    
                    <div class="bg-gradient-to-br from-teal-500 to-teal-700 rounded-3xl p-6 text-white shadow-lg">
                        <span class="text-xs font-bold uppercase tracking-widest opacity-80">Available to Withdraw</span>
                        <div class="text-4xl font-black mt-2">TZS {{ number_format($availableBalance) }}</div>
                        <button class="mt-4 w-full py-2 bg-white/20 hover:bg-white/30 rounded-lg text-xs font-bold uppercase tracking-widest transition-colors">
                            Request Payout
                        </button>
                    </div>
                @endif
                
                <div class="{{ Auth::user()->role === 'worker' ? 'md:col-span-3' : 'md:col-span-3' }}">
                    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-3xl p-6 border border-gray-100 dark:border-gray-700">
                        <h4 class="font-bold text-gray-900 dark:text-gray-100 mb-6">Transaction History</h4>
                        
                        <div class="space-y-4">
                            @forelse($transactions as $tx)
                                <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700/30 rounded-2xl">
                                    <div class="flex items-center gap-4">
                                        <div class="p-3 rounded-full {{ $tx->type === 'payment' ? 'bg-red-100 text-red-600' : 'bg-green-100 text-green-600' }}">
                                            @if($tx->type === 'payment')
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
                                            @else
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="font-bold text-gray-900 dark:text-gray-100">
                                                {{ $tx->type === 'payment' ? 'Payment to Escrow' : 'Wallet Payout' }}
                                            </div>
                                            <div class="text-xs text-gray-500">
                                                {{ $tx->created_at->format('M d, Y H:i') }} &bull; Ref: {{ $tx->reference }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-right flex flex-col items-end gap-2">
                                        <div class="font-bold {{ $tx->type === 'payment' ? 'text-gray-900 dark:text-gray-100' : 'text-green-600' }}">
                                            {{ $tx->type === 'payment' ? '-' : '+' }} TZS {{ number_format($tx->amount) }}
                                        </div>
                                        <div class="flex items-center gap-2">
                                            @if($tx->status === 'held')
                                                <div class="flex items-center gap-1 px-1.5 py-0.5 bg-indigo-50 text-indigo-700 text-[10px] font-black uppercase rounded border border-indigo-100">
                                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                                    Mtaa Shield™
                                                </div>
                                            @endif
                                            <span class="text-[10px] font-black uppercase tracking-widest px-2 py-0.5 rounded-full
                                                {{ $tx->status === 'held' ? 'bg-amber-100 text-amber-800' : ($tx->status === 'disputed' ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800') }}">
                                                {{ $tx->isDisputed() ? 'Under Review' : $tx->status }}
                                            </span>
                                        </div>
                                        
                                        @if($tx->status === 'held' && Auth::id() === $tx->user_id && !$tx->isDisputed())
                                            <button @click="openDispute({{ $tx->id }})" class="text-[10px] font-black text-red-600 hover:underline uppercase tracking-tighter">Report Issue</button>
                                        @elseif($tx->isDisputed())
                                            <span class="text-[9px] text-red-400 italic">Dispute opened {{ $tx->disputed_at->diffForHumans() }}</span>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-12 text-gray-500">
                                    No transactions yet.
                                </div>
                            @endforelse
                        </div>
                        <div class="mt-4">
                            {{ $transactions->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div x-data="{ 
        disputeModal: false, 
        disputeId: null,
        openDispute(id) {
            this.disputeId = id;
            this.disputeModal = true;
        }
    }">
        <!-- Dispute Modal -->
        <div x-show="disputeModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" @click="disputeModal = false"></div>
            <div class="flex min-h-full items-center justify-center p-4">
                <div class="relative transform overflow-hidden rounded-3xl bg-white dark:bg-gray-800 text-left shadow-2xl transition-all sm:w-full sm:max-w-lg border border-gray-100 dark:border-gray-700">
                    <div class="p-8">
                        <div class="w-16 h-16 bg-red-50 text-red-600 rounded-2xl flex items-center justify-center mb-6">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.268 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        </div>
                        <h3 class="text-xl font-black text-gray-900 dark:text-gray-100 mb-2">Report Service Issue</h3>
                        <p class="text-sm text-gray-500 mb-6">Opening a dispute will pause the release of funds to the worker. Our team will investigate the case.</p>
                        
                        <form :action="`/dispute/${disputeId}`" method="POST">
                            @csrf
                            <div class="mb-6">
                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Explain the Problem</label>
                                <textarea name="reason" rows="4" required class="w-full rounded-2xl border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition-all py-3 px-4 text-sm" placeholder="Tell us what went wrong..."></textarea>
                            </div>
                            <div class="flex gap-4">
                                <button type="submit" class="flex-1 py-4 bg-red-600 text-white font-black rounded-2xl shadow-xl shadow-red-500/20 active:scale-95 transition-all uppercase tracking-widest text-xs">Open Dispute</button>
                                <button type="button" @click="disputeModal = false" class="flex-1 py-4 bg-gray-100 text-gray-500 font-black rounded-2xl active:scale-95 transition-all uppercase tracking-widest text-xs">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
