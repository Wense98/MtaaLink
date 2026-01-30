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
                                    @if(request()->filled('lat'))
                                        <option value="distance" @selected(request('sort') == 'distance')>Nearby (Distance)</option>
                                    @endif
                                </select>
                            </div>
                        </div>

                        <!-- Near Me Feature -->
                        <div class="mt-4 p-4 bg-teal-50 rounded-2xl border border-teal-100 flex items-center justify-between group" x-data="{ locating: false }">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-teal-600 shadow-sm animate-bounce-slow">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                </div>
                                <div>
                                    <p class="text-xs font-black text-gray-900 uppercase">Find Near Me</p>
                                    <p class="text-[10px] text-teal-600 font-bold">Show professionals in your exact location</p>
                                </div>
                            </div>
                            <button type="button" 
                                    @click="locating = true; navigator.geolocation.getCurrentPosition(
                                        pos => { 
                                            window.location.href = `{{ route('search.index') }}?lat=${pos.coords.latitude}&lon=${pos.coords.longitude}&sort=distance`;
                                        },
                                        err => { 
                                            locating = false; 
                                            alert('Please enable location access to use this feature.'); 
                                        }
                                    )" 
                                    class="bg-white px-4 py-2 rounded-xl text-[10px] font-black uppercase text-teal-600 shadow-sm hover:shadow-md transition-all active:scale-95 border border-teal-100">
                                <span x-show="!locating">Activate</span>
                                <span x-show="locating" x-cloak>Locating...</span>
                            </button>
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

            <!-- View Toggle & Results Grid -->
            <div class="lg:col-span-3" x-data="{ view: 'grid' }">
                <div class="flex items-center justify-between mb-6">
                    <p class="text-sm text-gray-500 font-medium">Found <span class="text-gray-900 font-bold">{{ $profiles->total() }}</span> verified professionals</p>
                    
                    <div class="flex items-center gap-2 p-1 bg-gray-100/80 rounded-xl">
                        <button @click="view = 'grid'" :class="view === 'grid' ? 'bg-white shadow-sm text-teal-600' : 'text-gray-500 hover:text-gray-700'" class="px-3 py-1.5 rounded-lg text-xs font-black uppercase tracking-widest transition-all flex items-center gap-2">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h11"></path></svg>
                            List
                        </button>
                        <button @click="view = 'map'; setTimeout(() => initMap(), 100)" :class="view === 'map' ? 'bg-white shadow-sm text-teal-600' : 'text-gray-500 hover:text-gray-700'" class="px-3 py-1.5 rounded-lg text-xs font-black uppercase tracking-widest transition-all flex items-center gap-2">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A2 2 0 013 15.382V6.618a2 2 0 011.106-1.789L9 2l5.447 2.724A2 2 0 0115 6.618v8.764a2 2 0 01-1.106 1.789L9 20z"></path></svg>
                            Map
                        </button>
                    </div>
                </div>

                <div x-show="view === 'grid'" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
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
                             
                             <!-- Distance Badge Overlay -->
                             @if(request()->filled('lat') && isset($p->distance))
                                <div class="absolute top-4 left-4 z-10 bg-black/30 backdrop-blur-md px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest text-white border border-white/20 flex items-center gap-1.5 shadow-xl">
                                    <div class="w-1.5 h-1.5 bg-green-400 rounded-full animate-ping"></div>
                                    {{ number_format($p->distance, 1) }} KM Away
                                </div>
                             @endif
                             
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
                        <div class="px-6 py-5 bg-gray-50 border-t border-gray-100 flex items-center justify-between gap-2">
                             <div class="flex items-center gap-1.5">
                                 @if($p->user->phone)
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $p->user->phone) }}" target="_blank" class="w-8 h-8 rounded-lg bg-green-50 text-green-600 flex items-center justify-center hover:bg-green-100 transition-colors" title="WhatsApp">
                                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                                    </a>
                                    <a href="tel:{{ $p->user->phone }}" class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center hover:bg-blue-100 transition-colors" title="Call">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                    </a>
                                 @endif
                             </div>
                            <a href="{{ route('worker.show', $p->user->id) }}" class="inline-flex items-center px-4 py-2 bg-gray-900 text-white text-xs font-bold rounded-xl hover:bg-teal-600 transition-all shadow-md active:scale-95">
                                Profile
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
                </div>

                <!-- Map View Container -->
                <div x-show="view === 'map'" x-cloak class="bg-white rounded-3xl overflow-hidden border border-gray-100 h-[600px] shadow-2xl relative">
                    <div id="search-map" class="w-full h-full z-0"></div>
                </div>

                <div class="mt-8">
                    {{ $profiles->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Map Scripts -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        let searchMap;
        function initMap() {
            if (searchMap) return;
            
            searchMap = L.map('search-map').setView([-6.7924, 39.2083], 12);
            
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(searchMap);

            // Pass profiles data from Blade to JS
            const profiles = @json($profiles->items());
            const bounds = [];

            profiles.forEach(p => {
                if (p.latitude && p.longitude) {
                    const marker = L.marker([p.latitude, p.longitude]).addTo(searchMap);
                    
                    const popupContent = `
                        <div class="p-2 min-w-[150px]">
                            <h4 class="font-bold text-gray-900 mb-1">${p.user.name}</h4>
                            <p class="text-[10px] text-teal-600 font-extrabold uppercase tracking-widest mb-2">${p.service ? p.service.name : 'Professional'}</p>
                            <a href="/worker/${p.user.id}" class="block w-full text-center py-1.5 bg-gray-900 text-white text-[10px] font-bold rounded-lg uppercase">View Profile</a>
                        </div>
                    `;
                    
                    marker.bindPopup(popupContent);
                    bounds.push([p.latitude, p.longitude]);
                }
            });

            if (bounds.length > 0) {
                searchMap.fitBounds(bounds, { padding: [50, 50] });
            }
        }
    </script>
</x-app-layout>