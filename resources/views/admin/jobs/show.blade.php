<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admin: Job Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- Job Info -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white dark:bg-gray-800 rounded-3xl p-8 shadow-sm border border-gray-100 dark:border-gray-700">
                        <div class="flex items-center justify-between mb-6">
                            <span class="px-3 py-1 bg-teal-50 text-teal-600 text-xs font-black rounded-full uppercase tracking-widest">
                                {{ $job->service->name }}
                            </span>
                             <span class="text-xs font-black uppercase tracking-widest text-gray-400">
                                Posted {{ $job->created_at->diffForHumans() }}
                            </span>
                        </div>

                        <h3 class="text-3xl font-black text-gray-900 dark:text-gray-100 mb-6">
                            {{ $job->title }}
                        </h3>

                        <div class="prose dark:prose-invert max-w-none text-gray-600 dark:text-gray-300 leading-relaxed mb-8">
                            {!! nl2br(e($job->description)) !!}
                        </div>

                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 bg-gray-50 dark:bg-gray-700/30 p-6 rounded-2xl">
                             <div>
                                <span class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Budget</span>
                                <span class="block text-sm font-bold text-teal-600">TZS {{ number_format($job->budget) }}</span>
                            </div>
                            <div>
                                <span class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Region</span>
                                <span class="block text-sm font-bold text-gray-800">{{ $job->region }}</span>
                            </div>
                            <div>
                                <span class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">District</span>
                                <span class="block text-sm font-bold text-gray-800">{{ $job->district }}</span>
                            </div>
                            <div>
                                <span class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Ward</span>
                                <span class="block text-sm font-bold text-gray-800">{{ $job->ward }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Bids -->
                    <div class="bg-white dark:bg-gray-800 rounded-3xl p-8 shadow-sm border border-gray-100 dark:border-gray-700">
                        <h4 class="font-bold text-lg text-gray-900 dark:text-gray-100 mb-6">Submitted Bids ({{ $job->bids->count() }})</h4>
                        
                        <div class="space-y-4">
                            @forelse($job->bids as $bid)
                                <div class="p-4 rounded-2xl border {{ $bid->status === 'accepted' ? 'border-teal-500 bg-teal-50/20' : 'border-gray-100 bg-gray-50' }}">
                                    <div class="flex items-center justify-between mb-2">
                                        <div class="flex items-center gap-3">
                                            <div class="font-bold text-gray-900">{{ $bid->worker->name }}</div>
                                            <span class="px-2 py-0.5 text-[10px] uppercase font-black rounded-full
                                                {{ $bid->status === 'accepted' ? 'bg-green-100 text-green-700' : 'bg-gray-200 text-gray-600' }}">
                                                {{ $bid->status }}
                                            </span>
                                        </div>
                                        <div class="text-sm font-black text-gray-900">TZS {{ number_format($bid->amount) }}</div>
                                    </div>
                                    <p class="text-xs text-gray-600 italic">"{{ $bid->message }}"</p>
                                    <div class="mt-2 text-[10px] text-gray-400 font-bold uppercase tracking-widest">
                                        Duration: {{ $bid->estimated_duration ?? 'N/A' }}
                                    </div>
                                </div>
                            @empty
                                <p class="text-gray-500 italic text-sm">No bids submitted yet.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Admin Actions -->
                <div class="lg:col-span-1 space-y-6">
                    <div class="bg-white dark:bg-gray-800 rounded-3xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
                        <h4 class="font-bold text-gray-900 mb-4">Moderation Actions</h4>
                        
                        @if($job->status !== 'cancelled' && $job->status !== 'completed')
                            <form action="{{ route('admin.jobs.close', $job->id) }}" method="POST" class="mb-3">
                                @csrf
                                <button type="submit" class="w-full py-3 bg-amber-500 hover:bg-amber-600 text-white font-bold rounded-xl shadow-lg shadow-amber-500/30 transition-all uppercase text-xs tracking-widest" onclick="return confirm('Are you sure you want to cancel this job? This cannot be undone.');">
                                    Cancel Job
                                </button>
                            </form>
                        @endif

                        <form action="{{ route('admin.jobs.destroy', $job->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full py-3 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl shadow-lg shadow-red-600/30 transition-all uppercase text-xs tracking-widest" onclick="return confirm('Delete this job permanently?');">
                                Delete Permanently
                            </button>
                        </form>
                    </div>

                    <div class="bg-white dark:bg-gray-800 rounded-3xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
                        <h4 class="font-bold text-gray-900 mb-4">Customer Details</h4>
                         <div class="flex items-center gap-3 mb-4">
                            <div class="w-12 h-12 rounded-full bg-gray-200 flex items-center justify-center font-bold text-gray-500">
                                {{ substr($job->user->name, 0, 1) }}
                            </div>
                            <div>
                                <div class="font-bold text-gray-900">{{ $job->user->name }}</div>
                                <div class="text-xs text-gray-500">{{ $job->user->email }}</div>
                                <div class="text-xs text-gray-500">{{ $job->user->phone }}</div>
                            </div>
                        </div>
                        <div class="pt-4 border-t border-gray-100">
                            <div class="flex justify-between items-center text-xs">
                                <span class="text-gray-500">Total Jobs Posted</span>
                                <span class="font-bold text-gray-900">{{ $job->user->publicJobs->count() }}</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
