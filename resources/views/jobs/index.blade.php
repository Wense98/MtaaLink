@extends('layouts.app')

@section('title','Mtaa Marketplace — Browse Jobs')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Mtaa Marketplace — Browse Jobs') }}
    </h2>
@endsection

@section('content')
  <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Filters & Promo Section -->
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8 mb-8">
                <!-- Sidebar Filters -->
                <div class="lg:col-span-1">
                    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-3xl p-6 border border-gray-100 dark:border-gray-700 sticky top-24">
                        <h3 class="font-bold text-lg text-gray-900 dark:text-gray-100 mb-6 flex items-center gap-2">
                            <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                            Filter Opportunity
                        </h3>
                        
                        <form method="GET" action="{{ route('jobs.index') }}" class="space-y-6">
                            <div>
                                <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Category</label>
                                <select name="service_id" class="w-full rounded-xl border-gray-100 dark:border-gray-600 dark:bg-gray-700 text-sm focus:ring-teal-500">
                                    <option value="">All Categories</option>
                                    @foreach($services as $service)
                                        <option value="{{ $service->id }}" @selected(request('service_id') == $service->id)>{{ $service->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2">Region</label>
                                <input type="text" name="region" placeholder="e.g. Dar es Salaam" value="{{ request('region') }}" class="w-full rounded-xl border-gray-100 dark:border-gray-600 dark:bg-gray-700 text-sm focus:ring-teal-500">
                            </div>

                            <button type="submit" class="w-full py-3 bg-gray-900 text-white font-black rounded-xl text-xs uppercase tracking-widest hover:bg-black transition-all shadow-lg active:scale-95">
                                Re-Index Board
                            </button>
                            
                            <a href="{{ route('jobs.index') }}" class="block text-center text-xs font-bold text-gray-400 hover:text-gray-600 underline">Clear Filters</a>
                        </form>

                        @if(Auth::user()->role === 'customer')
                            <div class="mt-8 pt-8 border-t border-gray-100">
                                <p class="text-[10px] text-gray-400 font-bold uppercase mb-4 tracking-tighter text-center leading-none">Can't find what you need?</p>
                                <a href="{{ route('jobs.create') }}" class="block w-full text-center py-4 bg-teal-600 text-white font-black rounded-2xl shadow-xl shadow-teal-500/20 hover:bg-teal-700 transition-all uppercase tracking-widest text-xs">
                                    Post a Job
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Job List -->
                <div class="lg:col-span-3">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center gap-3">
                            <div class="w-2 h-2 rounded-full bg-red-500 animate-pulse"></div>
                            <h3 class="font-bold text-gray-900 dark:text-gray-100 italic">Live Opportunities</h3>
                        </div>
                        <span class="text-xs font-medium text-gray-500">Showing {{ $jobs->count() }} of {{ $jobs->total() }} matches</span>
                    </div>

                    <div class="space-y-6">
                        @forelse($jobs as $job)
                            <div class="bg-white dark:bg-gray-800 rounded-3xl p-6 shadow-sm border border-gray-100 dark:border-gray-700 hover:shadow-xl transition-all duration-300 group relative">
                                <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                                    <div class="flex-grow">
                                        <div class="flex items-center gap-3 mb-2">
                                            <span class="px-2.5 py-1 bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 text-[10px] font-black rounded-full border border-indigo-100 uppercase tracking-widest">
                                                {{ $job->service->name }}
                                            </span>
                                            <span class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">
                                                By {{ $job->user->name }}
                                            </span>
                                        </div>
                                        <h4 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-2 group-hover:text-teal-600 transition-colors">
                                            {{ $job->title }}
                                        </h4>
                                        <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-2 mb-4">
                                            {{ $job->description }}
                                        </p>
                                        
                                        <div class="flex flex-wrap items-center gap-4 text-xs font-medium text-gray-500">
                                            <div class="flex items-center gap-1.5">
                                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                                {{ $job->ward }}, {{ $job->district }}
                                            </div>
                                            <div class="flex items-center gap-1.5">
                                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                Posted {{ $job->created_at->diffForHumans() }}
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="flex flex-col items-center justify-center md:items-end gap-3 min-w-[140px]">
                                        <div class="text-center md:text-right">
                                            <span class="block text-xl font-black text-gray-900 dark:text-gray-100">TZS {{ number_format($job->budget) }}</span>
                                            <span class="text-[10px] text-gray-400 font-bold uppercase">Estimated Budget</span>
                                        </div>
                                        <a href="{{ route('jobs.show', $job->id) }}" class="w-full text-center px-6 py-3 bg-gray-900 text-white rounded-xl text-xs font-black uppercase tracking-widest hover:bg-teal-600 transition-all shadow-lg active:scale-95">
                                            Check & Bid
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-20 bg-white rounded-3xl border-2 border-dashed border-gray-100">
                                <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-300">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                </div>
                                <p class="text-gray-500 font-medium">No active jobs matches your search currently.</p>
                                @if(Auth::user()->role === 'customer')
                                    <a href="{{ route('jobs.create') }}" class="text-teal-600 font-bold underline mt-2 inline-block">Post a new job now</a>
                                @endif
                            </div>
                        @endforelse

                        <div class="mt-8">
                            {{ $jobs->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
