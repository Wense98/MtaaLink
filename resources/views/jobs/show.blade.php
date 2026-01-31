@extends('layouts.app')

@section('title','Mtaa Market — Requirement Details')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Mtaa Market — Requirement Details') }}
    </h2>
@endsection

@section('content')
  <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- Job Description Column -->
                <div class="lg:col-span-2 space-y-8">
                    <div class="bg-white dark:bg-gray-800 rounded-3xl p-8 shadow-sm border border-gray-100 dark:border-gray-700">
                        <div class="flex items-center gap-3 mb-6">
                            <span class="px-3 py-1 bg-teal-50 text-teal-600 text-[10px] font-black rounded-full border border-teal-100 uppercase tracking-widest">
                                {{ $job->service->name }}
                            </span>
                            <span class="text-[10px] text-gray-400 font-bold uppercase tracking-widest flex items-center gap-1">
                                <span class="w-1 h-1 rounded-full bg-red-400"></span>
                                {{ ucfirst($job->status) }}
                            </span>
                        </div>

                        <h3 class="text-3xl font-black text-gray-900 dark:text-gray-100 mb-6 leading-tight">
                            {{ $job->title }}
                        </h3>

                        <div class="prose dark:prose-invert max-w-none text-gray-600 dark:text-gray-300 leading-relaxed mb-8">
                            {!! nl2br(e($job->description)) !!}
                        </div>

                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 p-6 bg-gray-50 dark:bg-gray-700/30 rounded-3xl border border-gray-100 dark:border-gray-600">
                            <div>
                                <span class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Customer</span>
                                <span class="block text-xs font-bold text-gray-900 dark:text-gray-200">{{ $job->user->name }}</span>
                            </div>
                            <div>
                                <span class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Budget</span>
                                <span class="block text-xs font-bold text-teal-600">TZS {{ number_format($job->budget) }}</span>
                            </div>
                            <div>
                                <span class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Location</span>
                                <span class="block text-xs font-bold text-gray-900 dark:text-gray-200">{{ $job->ward }}</span>
                            </div>
                            <div>
                                <span class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Expiry</span>
                                <span class="block text-xs font-bold text-red-500">{{ $job->expires_at ? $job->expires_at->format('M d') : 'No Limit' }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Market Bids (Visible to all, but actions restricted) -->
                    <div class="space-y-6">
                        <div class="flex items-center justify-between px-4">
                            <h4 class="font-bold text-lg text-gray-900 dark:text-gray-100 italic">Professional Quotes</h4>
                            <span class="text-xs font-bold text-gray-400 uppercase">{{ $job->bids->count() }} Bids Submitted</span>
                        </div>

                        @forelse($job->bids as $bid)
                            <div class="bg-white dark:bg-gray-800 rounded-3xl p-6 shadow-sm border-2 {{ $bid->status === 'accepted' ? 'border-teal-500 bg-teal-50/10' : 'border-gray-50' }} dark:border-gray-700 relative overflow-hidden group">
                                @if($bid->status === 'accepted')
                                    <div class="absolute top-0 right-0 px-6 py-2 bg-teal-500 text-white text-[10px] font-black uppercase tracking-widest rounded-bl-2xl">
                                        Assigned
                                    </div>
                                @endif

                                <div class="flex items-start gap-4">
                                    <div class="w-12 h-12 rounded-2xl bg-indigo-50 dark:bg-indigo-900/30 flex items-center justify-center text-indigo-600 font-bold text-lg">
                                         @if($bid->worker->avatar)
                                            <img src="{{ asset('storage/' . $bid->worker->avatar) }}" class="w-full h-full object-cover rounded-2xl shadow-sm">
                                         @else
                                            {{ substr($bid->worker->name, 0, 1) }}
                                         @endif
                                    </div>
                                    <div class="flex-grow">
                                        <div class="flex items-center justify-between mb-2">
                                            <div>
                                                <h5 class="font-bold text-gray-900 dark:text-gray-100 leading-none mb-1">{{ $bid->worker->name }}</h5>
                                                <div class="flex items-center gap-1.5">
                                                    <span class="text-[10px] font-bold text-teal-600">{{ $bid->worker->workerProfile->service->name }}</span>
                                                    <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                                                    <span class="text-[10px] text-gray-400">{{ $bid->created_at->diffForHumans() }}</span>
                                                </div>
                                            </div>
                                            <div class="text-right">
                                                <span class="block text-lg font-black text-gray-900 dark:text-gray-100">TZS {{ number_format($bid->amount) }}</span>
                                                <span class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Offer</span>
                                            </div>
                                        </div>
                                        <p class="text-sm text-gray-600 dark:text-gray-400 italic bg-gray-50 dark:bg-gray-700/20 p-4 rounded-xl mb-4 border-l-2 border-gray-200">
                                            "{{ $bid->message }}"
                                        </p>

                                        <div class="flex items-center justify-between gap-4">
                                            <div class="flex items-center gap-4 text-[10px] font-black uppercase tracking-tighter text-gray-400">
                                                @if($bid->estimated_duration)
                                                    <span>Duration: {{ $bid->estimated_duration }}</span>
                                                @endif
                                            </div>
                                            
                                            <div class="flex items-center gap-2">
                                                <a href="{{ route('worker.show', $bid->worker->id) }}" class="text-[10px] font-black text-teal-600 uppercase tracking-widest hover:underline">View Bio</a>
                                                
                                                @if(Auth::id() === $job->user_id && $job->status === 'open')
                                                    <form action="{{ route('jobs.accept-bid', $bid->id) }}" method="POST" class="inline">
                                                        @csrf
                                                        <button type="submit" class="px-5 py-2 bg-teal-600 text-white text-[10px] font-black uppercase tracking-widest rounded-lg shadow-lg hover:bg-teal-700 transition-all active:scale-95">
                                                            Hire this Pro
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-12 bg-gray-50/50 rounded-3xl border-2 border-dashed border-gray-100">
                                <p class="text-gray-400 text-sm italic">Waiting for the first professional to bid...</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Action Sidebar -->
                <div class="lg:col-span-1">
                    @if(Auth::user()->role === 'worker' && $job->status === 'open')
                        @php $alreadyBid = $job->bids()->where('worker_id', Auth::id())->exists(); @endphp
                        
                        <div class="bg-gray-900 text-white rounded-3xl p-8 shadow-2xl relative overflow-hidden sticky top-24">
                            <div class="absolute top-0 right-0 -mr-16 -mt-16 w-48 h-48 bg-teal-500/20 rounded-full blur-3xl"></div>
                            
                            @if($alreadyBid)
                                <div class="text-center">
                                    <div class="w-16 h-16 bg-teal-500/20 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <svg class="w-8 h-8 text-teal-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                    </div>
                                    <h4 class="text-xl font-bold mb-2">Quote Sent</h4>
                                    <p class="text-xs text-gray-400 mb-6">You've already submitted your quote for this job. You'll be notified if assigned.</p>
                                    <a href="{{ route('jobs.index') }}" class="block w-full text-center py-3 bg-white/10 hover:bg-white/20 text-white text-[10px] font-black uppercase tracking-widest rounded-xl transition-all">Browse More</a>
                                </div>
                            @else
                                <h4 class="text-xl font-bold mb-6 flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-teal-500 animate-pulse"></span>
                                    Submit Quote
                                </h4>

                                @if(Auth::user()->workerProfile && Auth::user()->workerProfile->service_id == $job->service_id)
                                    <form method="POST" action="{{ route('jobs.bid', $job->id) }}" class="space-y-6">
                                        @csrf
                                        <div>
                                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Your Professional Offer (TZS)</label>
                                            <input type="number" name="amount" required class="w-full bg-white/10 border-white/20 rounded-xl text-white placeholder-gray-500 focus:ring-teal-500" placeholder="e.g. 15000">
                                        </div>
                                        
                                        <div>
                                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Duration (e.g. 2 hours)</label>
                                            <input type="text" name="estimated_duration" class="w-full bg-white/10 border-white/20 rounded-xl text-white placeholder-gray-500 focus:ring-teal-500">
                                        </div>

                                        <div>
                                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Message to Customer</label>
                                            <textarea name="message" rows="4" required class="w-full bg-white/10 border-white/20 rounded-xl text-white placeholder-gray-500 focus:ring-teal-500" placeholder="Highlight why you are the best fit for this task..."></textarea>
                                        </div>

                                        <button type="submit" class="w-full py-4 bg-teal-500 text-gray-900 font-black rounded-2xl shadow-xl shadow-teal-500/30 hover:bg-teal-400 transition-all active:scale-95 text-xs uppercase tracking-widest">
                                            Apply for Job
                                        </button>
                                    </form>
                                @else
                                    <div class="p-6 bg-red-500/10 border border-red-500/20 rounded-2xl text-center">
                                         <p class="text-xs text-red-400 font-bold mb-4">Mismatched Specialist Category</p>
                                         <p class="text-[10px] text-gray-400 leading-relaxed mb-4">Your current profile focuses on <strong>{{ Auth::user()->workerProfile->service->name ?? 'N/A' }}</strong>. You can only bid on jobs matching your specialized service.</p>
                                         <a href="{{ route('worker-profile.edit') }}" class="text-[10px] text-white underline font-black">Edit Category</a>
                                    </div>
                                @endif
                            @endif
                        </div>
                    @else
                        <div class="bg-white dark:bg-gray-800 rounded-3xl p-8 shadow-sm border border-gray-100 dark:border-gray-700 sticky top-24">
                            <h4 class="font-bold text-gray-900 dark:text-gray-100 mb-4 italic">Safety Guidelines</h4>
                            <ul class="space-y-4 text-xs text-gray-500 font-medium">
                                <li class="flex items-start gap-3">
                                    <span class="w-5 h-5 bg-teal-50 text-teal-600 rounded-full flex items-center justify-center shrink-0">1</span>
                                    Check worker ratings before hiring.
                                </li>
                                <li class="flex items-start gap-3">
                                    <span class="w-5 h-5 bg-teal-50 text-teal-600 rounded-full flex items-center justify-center shrink-0">2</span>
                                    Only share contact details once assigned.
                                </li>
                                <li class="flex items-start gap-3">
                                    <span class="w-5 h-5 bg-teal-50 text-teal-600 rounded-full flex items-center justify-center shrink-0">3</span>
                                    Pay only after service completion.
                                </li>
                            </ul>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
@endsection
