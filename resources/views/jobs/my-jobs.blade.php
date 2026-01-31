@extends('layouts.app')

@section('title','Mtaa Market — My Posted Requirements')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Mtaa Market — My Posted Requirements') }}
    </h2>
@endsection

@section('content')
  <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h3 class="text-2xl font-black text-gray-900 dark:text-gray-100">Manage Your Requests</h3>
                    <p class="text-sm text-gray-500">Track bids from professionals and assign the best fit.</p>
                </div>
                <a href="{{ route('jobs.create') }}" class="px-8 py-4 bg-gray-900 text-white font-black rounded-3xl shadow-xl hover:bg-black transition-all text-xs uppercase tracking-widest active:scale-95 text-center">
                    Post New Job
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($jobs as $job)
                    <div class="bg-white dark:bg-gray-800 rounded-[2.5rem] p-8 shadow-sm border border-gray-100 dark:border-gray-700 hover:shadow-2xl transition-all duration-500 group">
                        <div class="flex items-center justify-between mb-6">
                            <span class="px-3 py-1 bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 text-[10px] font-black rounded-full border border-indigo-100 uppercase tracking-widest">
                                {{ $job->service->name }}
                            </span>
                            @if($job->status === 'open')
                                <span class="flex items-center gap-1.5 text-[10px] font-black text-green-500 uppercase tracking-widest">
                                    <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                                    Active
                                </span>
                            @else
                                <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">
                                    {{ ucfirst($job->status) }}
                                </span>
                            @endif
                        </div>

                        <h4 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-4 line-clamp-1 group-hover:text-teal-600 transition-colors">
                            {{ $job->title }}
                        </h4>

                        <div class="flex items-center gap-6 mb-8">
                            <div class="text-center">
                                <span class="block text-xl font-black text-gray-900 dark:text-gray-100">{{ $job->bids->count() }}</span>
                                <span class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Bids</span>
                            </div>
                            <div class="w-px h-8 bg-gray-100"></div>
                            <div class="text-center">
                                <span class="block text-xl font-black text-teal-600">TZS {{ number_format($job->budget, 0, '.', ',') }}</span>
                                <span class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Budget</span>
                            </div>
                        </div>

                        @if($job->status === 'open' && $job->bids->count() > 0)
                            <div class="mb-6 p-4 bg-amber-50 rounded-2xl border border-amber-100">
                                <p class="text-[10px] text-amber-700 font-bold uppercase tracking-wider leading-none mb-1">Attention Required</p>
                                <p class="text-xs text-amber-600">You have new quotes to review for this job.</p>
                            </div>
                        @endif

                        <a href="{{ route('jobs.show', $job->id) }}" class="w-full block text-center py-4 bg-gray-50 dark:bg-gray-700/50 text-gray-900 dark:text-gray-100 font-black rounded-2xl hover:bg-teal-600 hover:text-white transition-all text-xs uppercase tracking-widest shadow-sm">
                            View Deep Details
                        </a>
                    </div>
                @empty
                    <div class="col-span-1 md:col-span-3 py-24 text-center bg-gray-50/50 rounded-[3rem] border-2 border-dashed border-gray-100">
                        <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center mx-auto mb-6 shadow-sm">
                            <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                        </div>
                        <h4 class="text-xl font-bold text-gray-900 mb-2">No active requirements</h4>
                        <p class="text-gray-500 text-sm mb-8 max-w-sm mx-auto">When you post a requirement, it will appear here so you can manage incoming bids.</p>
                        <a href="{{ route('jobs.create') }}" class="inline-flex items-center gap-2 px-8 py-4 bg-teal-600 text-white font-black rounded-2xl shadow-xl shadow-teal-500/20 hover:scale-105 transition-all text-xs uppercase tracking-widest">
                            Start Your First Job Request
                        </a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
    @endsection
