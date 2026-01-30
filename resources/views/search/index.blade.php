<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Find Social Works') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Search & Filters Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8 border border-gray-100">
                <div class="p-6 bg-white border-b border-gray-100">
                    <form method="GET" action="{{ route('search.index') }}" class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                            <!-- Service Type -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Service Type</label>
                                <select name="service_id" class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500 shadow-sm text-sm">
                                    <option value="">All Services</option>
                                    @foreach($services as $service)
                                        <option value="{{ $service->id }}" @selected(request('service_id') == $service->id)>{{ $service->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Location (Simplified to one field for UX, but mapping to Ward for now) -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Location (Mtaa/Ward)</label>
                                <input type="text" name="ward" placeholder="e.g. Sinza" value="{{ request('ward') }}" class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500 shadow-sm text-sm" />
                            </div>

                            <!-- Experience -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Min Experience</label>
                                <select name="min_experience" class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500 shadow-sm text-sm">
                                    <option value="">Any Experience</option>
                                    <option value="1" @selected(request('min_experience') == 1)>1+ Year</option>
                                    <option value="3" @selected(request('min_experience') == 3)>3+ Years</option>
                                    <option value="5" @selected(request('min_experience') == 5)>5+ Years</option>
                                    <option value="10" @selected(request('min_experience') == 10)>10+ Years</option>
                                </select>
                            </div>

                            <!-- Rating -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Min Rating</label>
                                <select name="min_rating" class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500 shadow-sm text-sm">
                                    <option value="">Any Rating</option>
                                    <option value="4" @selected(request('min_rating') == 4)>4+ Stars</option>
                                    <option value="4.5" @selected(request('min_rating') == 4.5)>4.5+ Stars</option>
                                </select>
                            </div>

                            <!-- Sort -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Sort By</label>
                                <select name="sort" class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500 shadow-sm text-sm">
                                    <option value="newest" @selected(request('sort') == 'newest')>Newest First</option>
                                    <option value="price_low" @selected(request('sort') == 'price_low')>Price: Low to High</option>
                                    <option value="price_high" @selected(request('sort') == 'price_high')>Price: High to Low</option>
                                    <option value="experience" @selected(request('sort') == 'experience')>Most Experienced</option>
                                </select>
                            </div>
                        </div>

                        <div class="flex items-center justify-between pt-4 border-t border-gray-50">
                            <a href="{{ route('search.index') }}" class="text-sm text-gray-500 hover:text-gray-700 underline">Clear Filters</a>
                            <button type="submit" class="px-8 py-2.5 bg-gray-900 text-white font-bold rounded-lg shadow-lg hover:bg-gray-800 transition-all transform hover:-translate-y-0.5">
                                Show Workers
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Results Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($profiles as $p)
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-xl transition-all duration-300 overflow-hidden flex flex-col group relative">
                        <!-- Favorite Badge (Top Right) -->
                        @auth
                            @if(Auth::user()->favorites->contains($p->id))
                                <div class="absolute top-4 right-4 z-10 bg-white/90 backdrop-blur-sm p-2 rounded-full shadow-sm">
                                    <svg class="w-5 h-5 text-red-500 fill-current" viewBox="0 0 24 24"><path d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0112 5.052 5.5 5.5 0 0116.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 01-4.244 3.17 15.247 15.247 0 01-.383.219l-.022.012-.007.004-.003.001a.752.752 0 01-.704 0l-.003-.001z" /></svg>
                                </div>
                            @endif
                        @endauth

                        <!-- Card Header / Cover -->
                        <div class="h-32 bg-gradient-to-br from-teal-500 to-blue-600 relative overflow-hidden">
                             <!-- Subtle Pattern -->
                             <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(white 1px, transparent 1px); background-size: 10px 10px;"></div>
                             
                            <!-- Profile Avatar -->
                            <div class="absolute -bottom-12 left-6">
                                <div class="w-24 h-24 rounded-2xl border-4 border-white shadow-lg bg-gray-50 flex items-center justify-center overflow-hidden">
                                     @if($p->user->avatar)
                                        <img src="{{ asset('storage/' . $p->user->avatar) }}" class="w-full h-full object-cover">
                                     @else
                                        <span class="text-2xl font-bold text-teal-600 uppercase">{{ substr($p->user->name, 0, 1) }}</span>
                                     @endif
                                </div>
                            </div>
                        </div>

                        <div class="pt-16 p-6 flex-grow">
                            <div class="flex justify-between items-start mb-1">
                                <div class="flex items-center gap-1.5 min-w-0">
                                    <h3 class="text-xl font-bold text-gray-900 group-hover:text-teal-600 transition-colors truncate">{{ $p->user->name }}</h3>
                                    @if($p->user->is_verified)
                                        <svg class="w-5 h-5 text-teal-500 fill-current flex-shrink-0" viewBox="0 0 20 20" title="Verified Professional">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                    @endif
                                </div>
                                <div class="flex items-center text-yellow-500 font-bold bg-yellow-50 px-2 py-0.5 rounded text-sm">
                                    <svg class="w-4 h-4 mr-0.5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                    {{ number_format($p->user->receivedReviews->avg('rating') ?? 5, 1) }}
                                </div>
                            </div>

                            <p class="text-sm font-semibold text-teal-600 uppercase tracking-wide mb-4">{{ $p->service?->name ?? 'Social Worker' }}</p>

                            <div class="space-y-3 text-sm text-gray-600">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    </div>
                                    <span class="font-medium truncate">{{ $p->ward }}, {{ $p->district }}</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                    </div>
                                    <span>{{ $p->experience_years }} Years Pro Experience</span>
                                </div>
                                <div class="flex items-center gap-2">
                                     <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                    <span class="font-bold text-gray-900 border-b-2 border-teal-100">TZS {{ number_format($p->price) }} <span class="text-xs font-normal text-gray-400">start</span></span>
                                </div>
                            </div>
                        </div>

                        <!-- Card Footer -->
                        <div class="px-6 py-5 bg-gray-50 border-t border-gray-100 flex items-center justify-between">
                             <span class="text-xs text-gray-400">{{ $p->views_count }} views</span>
                            <a href="{{ route('worker.show', $p->user->id) }}" class="inline-flex items-center px-6 py-2 bg-gray-900 text-white font-bold rounded-xl hover:bg-teal-600 transition-all shadow-md active:scale-95">
                                View Full Profile
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900">No workers found........</h3>
                        <p class="text-gray-500">Try adjusting your location filters or search for a different service...</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-8">
                {{ $profiles->links() }}
            </div>
        </div>
    </div>
</x-app-layout>