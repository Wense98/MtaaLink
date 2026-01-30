<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Worker Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ __('Worker Information') }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                {{ __("Update your professional details. This information will be visible to everyone searching for your services.") }}
                            </p>
                        </header>

                        <form method="post" action="{{ route('worker-profile.update') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
                            @csrf
                            @method('patch')

                            <!-- Service Category -->
                            <div>
                                <x-input-label for="service_id" :value="__('Service Category')" />
                                <select id="service_id" name="service_id" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>
                                    <option value="">Select a Service...</option>
                                    @foreach($services as $service)
                                        <option value="{{ $service->id }}" {{ old('service_id', $profile->service_id) == $service->id ? 'selected' : '' }}>
                                            {{ $service->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('service_id')" />
                            </div>

                            <!-- Bio -->
                            <div>
                                <x-input-label for="bio" :value="__('Bio / Description')" />
                                <textarea id="bio" name="bio" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" rows="4">{{ old('bio', $profile->bio) }}</textarea>
                                <p class="mt-1 text-sm text-gray-500">Briefly describe what you do.</p>
                                <x-input-error class="mt-2" :messages="$errors->get('bio')" />
                            </div>

                            <!-- Skills -->
                            <div>
                                <x-input-label for="skills" :value="__('Specialized Skills')" />
                                <x-text-input id="skills" name="skills" type="text" class="mt-1 block w-full" :value="old('skills', $profile->skills)" placeholder="e.g. Pipe Leakage, Wiring, CCTV installation" />
                                <p class="mt-1 text-sm text-gray-500 italic">Separate skills with commas.</p>
                                <x-input-error class="mt-2" :messages="$errors->get('skills')" />
                            </div>

                            <!-- Experience (Years) -->
                            <div>
                                <x-input-label for="experience_years" :value="__('Experience (Years)')" />
                                <x-text-input id="experience_years" name="experience_years" type="number" class="mt-1 block w-full" :value="old('experience_years', $profile->experience_years)" required min="0" />
                                <x-input-error class="mt-2" :messages="$errors->get('experience_years')" />
                            </div>

                            <!-- Price (Optional) -->
                            <div>
                                <x-input-label for="price" :value="__('Starting Price (TZS) - Optional')" />
                                <x-text-input id="price" name="price" type="number" class="mt-1 block w-full" :value="old('price', $profile->price)" step="0.01" />
                                <x-input-error class="mt-2" :messages="$errors->get('price')" />
                            </div>

                            <!-- Location Section -->
                            <div class="border-t pt-4 mt-6">
                                <h3 class="text-md font-medium text-gray-900 dark:text-gray-100 mb-4">Location Details</h3>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <!-- Region -->
                                    <div>
                                        <x-input-label for="region" :value="__('Region (Mkoa)')" />
                                        <x-text-input id="region" name="region" type="text" class="mt-1 block w-full" :value="old('region', $profile->region)" required />
                                        <x-input-error class="mt-2" :messages="$errors->get('region')" />
                                    </div>

                                    <!-- District -->
                                    <div>
                                        <x-input-label for="district" :value="__('District (Wilaya)')" />
                                        <x-text-input id="district" name="district" type="text" class="mt-1 block w-full" :value="old('district', $profile->district)" required />
                                        <x-input-error class="mt-2" :messages="$errors->get('district')" />
                                    </div>

                                    <!-- Ward -->
                                    <div>
                                        <x-input-label for="ward" :value="__('Ward (Kata)')" />
                                        <x-text-input id="ward" name="ward" type="text" class="mt-1 block w-full" :value="old('ward', $profile->ward)" required />
                                        <x-input-error class="mt-2" :messages="$errors->get('ward')" />
                                    </div>

                                    <!-- Street -->
                                    <div>
                                        <x-input-label for="street" :value="__('Street (Mtaa)')" />
                                        <x-text-input id="street" name="street" type="text" class="mt-1 block w-full" :value="old('street', $profile->street)" required />
                                        <x-input-error class="mt-2" :messages="$errors->get('street')" />
                                    </div>
                                </div>

                                <!-- Map Picker -->
                                <div class="mt-4">
                                    <x-input-label :value="__('Pin your location on Map (Optional)')" />
                                    <p class="text-xs text-gray-500 mb-2 italic">Drag the marker to your exact location in your Mtaa.</p>
                                    <div id="map" class="h-64 rounded-xl border border-gray-200 shadow-inner z-0"></div>
                                    <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude', $profile->latitude) }}">
                                    <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude', $profile->longitude) }}">
                                    <x-input-error class="mt-2" :messages="$errors->get('latitude')" />
                                </div>
                            </div>

                            <!-- Map Scripts -->
                            <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
                            <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    const defaultLat = {{ $profile->latitude ?? -6.7924 }};
                                    const defaultLon = {{ $profile->longitude ?? 39.2083 }};
                                    
                                    const map = L.map('map').setView([defaultLat, defaultLon], 13);
                                    
                                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                        attribution: '© OpenStreetMap contributors'
                                    }).addTo(map);

                                    const marker = L.marker([defaultLat, defaultLon], {
                                        draggable: true
                                    }).addTo(map);

                                    marker.on('dragend', function(event) {
                                        const position = marker.getLatLng();
                                        document.getElementById('latitude').value = position.lat;
                                        document.getElementById('longitude').value = position.lng;
                                    });

                                    map.on('click', function(e) {
                                        marker.setLatLng(e.latlng);
                                        document.getElementById('latitude').value = e.latlng.lat;
                                        document.getElementById('longitude').value = e.latlng.lng;
                                    });
                                });
                            </script>

                            <!-- Portfolio Section -->
                            <div class="border-t pt-4 mt-6">
                                <h3 class="text-md font-medium text-gray-900 dark:text-gray-100 mb-4">Portfolio / Work Gallery</h3>
                                
                                <div class="mb-4">
                                     <x-input-label for="portfolio_images" :value="__('Upload New Images (Max 5)')" />
                                     <input type="file" name="portfolio_images[]" multiple accept="image/*" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 cursor-pointer">
                                     <p class="text-xs text-gray-500 mt-1">Showcase your best work to attract more customers.</p>
                                </div>

                                @if($profile->portfolioImages->count() > 0)
                                    <div class="grid grid-cols-3 gap-2 mt-4">
                                        @foreach($profile->portfolioImages as $image)
                                            <div class="relative group">
                                                <img src="{{ asset('storage/' . $image->image_path) }}" class="w-full h-24 object-cover rounded-lg border border-gray-200">
                                                <button type="submit" form="delete-image-{{ $image->id }}" class="absolute top-1 right-1 bg-red-600 text-white rounded-full p-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>

                            <div class="flex items-center gap-4">
                                <x-primary-button>{{ __('Save Profile') }}</x-primary-button>

                                @if (session('status') === 'profile-updated')
                                    <p
                                        x-data="{ show: true }"
                                        x-show="show"
                                        x-transition
                                        x-init="setTimeout(() => show = false, 2000)"
                                        class="text-sm text-gray-600 dark:text-gray-400"
                                    >{{ __('Saved.') }}</p>
                                @endif
                            </div>
                        </form>
                    </section>
                    
                    <!-- Hidden Delete Forms for Images -->
                    @foreach($profile->portfolioImages as $image)
                        <form id="delete-image-{{ $image->id }}" action="{{ route('worker-profile.image.destroy', $image->id) }}" method="POST" class="hidden">
                            @csrf
                            @method('DELETE')
                        </form>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
