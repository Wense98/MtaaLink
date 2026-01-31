@extends('layouts.app')

@section('title','Mtaa Market — Post Your Requirement')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Mtaa Market — Post Your Requirement') }}
    </h2>
@endsection

@section('content')
  <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl rounded-3xl border border-gray-100 dark:border-gray-700">
                <div class="p-8">
                    <div class="flex items-center gap-4 mb-8">
                        <div class="w-12 h-12 bg-teal-50 text-teal-600 rounded-2xl flex items-center justify-center shadow-sm">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100">Describe what you need</h3>
                            <p class="text-xs text-gray-500 italic">Workers in your Mtaa will bid on this requirement.</p>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('jobs.store') }}" class="space-y-6">
                        @csrf

                        <!-- Title -->
                        <div>
                            <x-input-label for="title" :value="__('Job Title (Brief & Clear)')" />
                            <x-text-input id="title" name="title" type="text" class="mt-1 block w-full rounded-2xl" placeholder="e.g. Broken pipe in kitchen needs urgent repair" required />
                            <x-input-error class="mt-1 text-xs" :messages="$errors->get('title')" />
                        </div>

                        <!-- Service Category -->
                        <div>
                            <x-input-label for="service_id" :value="__('Which category of expert do you need?')" />
                            <select id="service_id" name="service_id" class="mt-1 block w-full rounded-2xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" required>
                                <option value="">Select Service</option>
                                @foreach($services as $service)
                                    <option value="{{ $service->id }}">{{ $service->name }}</option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-1 text-xs" :messages="$errors->get('service_id')" />
                        </div>

                        <!-- Description -->
                        <div>
                            <x-input-label for="description" :value="__('Detailed Description')" />
                            <textarea id="description" name="description" rows="5" class="mt-1 block w-full rounded-2xl border-gray-300 dark:border-gray-700 dark:bg-gray-900 focus:border-teal-500 focus:ring-4 focus:ring-teal-500/10 shadow-sm" placeholder="Tell the workers exactly what needs to be done..." required></textarea>
                            <x-input-error class="mt-1 text-xs" :messages="$errors->get('description')" />
                        </div>

                        <!-- Grid: Budget & Location -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="budget" :value="__('Estimated Budget (TZS)')" />
                                <x-text-input id="budget" name="budget" type="number" class="mt-1 block w-full rounded-2xl" placeholder="20,000" />
                                <p class="mt-1 text-[10px] text-gray-400">Total amount you're willing to pay.</p>
                            </div>
                            <div>
                                <x-input-label for="region" :value="__('Region')" />
                                <x-text-input id="region" name="region" type="text" class="mt-1 block w-full rounded-2xl" placeholder="Dar es Salaam" required />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="district" :value="__('District')" />
                                <x-text-input id="district" name="district" type="text" class="mt-1 block w-full rounded-2xl" placeholder="Kinondoni" required />
                            </div>
                            <div>
                                <x-input-label for="ward" :value="__('Ward/Mtaa')" />
                                <x-text-input id="ward" name="ward" type="text" class="mt-1 block w-full rounded-2xl" placeholder="Sinza" required />
                            </div>
                        </div>

                        <div class="pt-6">
                            <button type="submit" class="w-full py-4 bg-gray-900 text-white font-black rounded-3xl shadow-xl shadow-gray-400/20 hover:scale-[1.02] active:scale-95 transition-all text-sm uppercase tracking-widest">
                                Announce Request to Market
                            </button>
                            <p class="text-center text-[10px] text-gray-400 mt-4 leading-relaxed px-12 italic">
                                Note: Once announced, verified workers will visit this request and submit their best quotes. You can then choose the best one.
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
