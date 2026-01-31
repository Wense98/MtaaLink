@extends('layouts.app')

@section('title', $user->name . "'s Profile")

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ $user->name }}'s Profile
    </h2>
@endsection

@section('content')
  <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <!-- Left Column: Key Info -->
                <div class="md:col-span-1 space-y-6">
                    <!-- Profile Card -->
                        <div class="bg-white dark:bg-gray-800 shadow-xl rounded-2xl overflow-hidden text-center p-8 border border-gray-100 dark:border-gray-700 relative">
                            <!-- Availability Badge -->
                            <div class="absolute top-4 left-4">
                                @if($user->workerProfile->is_available)
                                    <span class="flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-green-50 text-green-700 text-xs font-bold border border-green-100">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span>
                                        Available
                                    </span>
                                @else
                                    <span class="flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-gray-50 text-gray-500 text-xs font-bold border border-gray-100">
                                        <span class="w-1.5 h-1.5 rounded-full bg-gray-300"></span>
                                        Busy
                                    </span>
                                @endif
                            </div>

                            <div class="mb-6">
                                <div class="mx-auto w-24 h-24 rounded-full bg-teal-50 text-teal-600 flex items-center justify-center text-4xl font-black overflow-hidden border border-teal-100">
                                    @if($user->workerProfile->avatar_path)
                                        <img src="{{ asset('storage/' . $user->workerProfile->avatar_path) }}" alt="{{ $user->name }} avatar" class="w-full h-full object-cover">
                                    @else
                                        <span class="uppercase text-teal-600">{{ substr($user->name, 0, 1) }}</span>
                                    @endif
                                </div>
                            </div>

                            <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-1">{{ $user->name }}</h1>
                            <p class="text-teal-600 font-bold text-sm uppercase tracking-wider mb-4">{{ $user->workerProfile->service->name ?? 'Social Worker' }}</p>

                            @if($user->is_verified)
                                <div class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-bold bg-indigo-50 text-indigo-700 border border-indigo-100 mb-6">
                                    <svg class="w-4 h-4 mr-1.5 text-indigo-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.64.304 1.24.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                    Pro Verified
                                </div>
                            @endif

                            <div class="grid grid-cols-2 gap-4 mb-6">
                                <!-- WhatsApp Button -->
                                @if($user->phone)
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $user->phone) }}" target="_blank" class="flex flex-col items-center justify-center py-3 bg-green-50 hover:bg-green-100 rounded-xl text-green-700 transition-all border border-green-100 group">
                                        <svg class="w-6 h-6 mb-1 group-hover:scale-110 transition-transform" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                                        <span class="text-[10px] font-bold uppercase">WhatsApp</span>
                                    </a>
                                    <!-- Call Button -->
                                    <a href="tel:{{ $user->phone }}" class="flex flex-col items-center justify-center py-3 bg-blue-50 hover:bg-blue-100 rounded-xl text-blue-700 transition-all border border-blue-100 group">
                                        <svg class="w-6 h-6 mb-1 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                        <span class="text-[10px] font-bold uppercase">Call Me</span>
                                    </a>
                                @endif
                            </div>

                            <div class="space-y-3 mb-6">
                                <button @click="open = true" class="w-full py-4 bg-gray-900 hover:bg-black text-white font-black rounded-xl shadow-xl transition-all transform active:scale-95 flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2-2v12a2 2 0 002 2z"></path></svg>
                                    Book Appointment
                                </button>

                                <a href="{{ route('chat.show', $user->id) }}" class="w-full py-4 bg-white text-gray-900 border-2 border-gray-900 hover:bg-gray-50 font-black rounded-xl shadow-sm transition-all transform active:scale-95 flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                                    Message Me
                                </a>
                            </div>

                            <div class="flex justify-center border-t border-gray-50 pt-4 mt-2">
                                <form action="{{ route('favorites.toggle', $user->workerProfile->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="flex items-center text-sm font-bold transition-all px-4 py-2 rounded-lg 
                                        {{ Auth::user() && Auth::user()->favorites->contains($user->workerProfile->id) ? 'text-red-600 bg-red-50' : 'text-gray-400 hover:text-red-500 hover:bg-gray-50' }}">
                                        <svg class="w-5 h-5 mr-2 {{ Auth::user() && Auth::user()->favorites->contains($user->workerProfile->id) ? 'fill-current' : 'fill-none stroke-current' }}" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                        </svg>
                                        {{ Auth::user() && Auth::user()->favorites->contains($user->workerProfile->id) ? 'Saved' : 'Save Worker' }}
                                    </button>
                                </form>
                            </div>
                        </div>

                    <!-- Achievements & Badges -->
                    @php $achievements = $user->workerProfile->getAchievements(); @endphp
                    @if(count($achievements) > 0)
                    <div class="bg-white dark:bg-gray-800 shadow-xl rounded-2xl p-6 border border-gray-100 dark:border-gray-700">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="p-2 bg-yellow-50 rounded-lg text-yellow-600">
                                <svg class="w-6 h-6 font-bold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
                            </div>
                            <h3 class="font-bold text-gray-900 dark:text-gray-100">Service Achievements</h3>
                        </div>
                        <div class="space-y-4">
                            @foreach($achievements as $badge)
                                <div class="flex items-center gap-3 p-3 rounded-xl bg-{{ $badge['color'] }}-50/50 border border-{{ $badge['color'] }}-100 group hover:shadow-md transition-all">
                                    <div class="w-10 h-10 bg-white rounded-lg shadow-sm flex items-center justify-center text-{{ $badge['color'] }}-600 group-hover:scale-110 transition-transform">
                                        @if($badge['icon'] === 'verified')
                                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                        @elseif($badge['icon'] === 'heart')
                                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path></svg>
                                        @elseif($badge['icon'] === 'star')
                                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                        @elseif($badge['icon'] === 'fire')
                                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12.395 2.553a1 1 0 00-1.4503-.342c-.714.442-1.531.634-2.311.634-2.127 0-3.991-1.45-3.991-3.595 0-.671.223-1.302.618-1.81a1 1 0 00-.162-1.313 1.001 1.001 0 00-1.144-.133C2.808 2.146 1.906 3.559 1.906 5.176c0 3.299 2.492 5.925 5.538 5.925.79 0 1.553-.171 2.237-.49a1 1 0 00.538-.89 1 1 0 00-.63-.919c-.392-.156-.73-.43-1.002-.796 1.047-.033 2.044-.317 2.846-.826 1.517-.962 2.327-2.346 2.327-3.853 0-.62-.12-1.222-.34-1.783z" clip-rule="evenodd"></path></svg>
                                        @elseif($badge['icon'] === 'shield-check')
                                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="text-[10px] font-black text-{{ $badge['color'] }}-600 uppercase tracking-widest leading-none mb-1">{{ $badge['name'] }}</p>
                                        <p class="text-[10px] text-gray-500 font-medium leading-tight">{{ $badge['description'] }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Location Card -->
                    <div class="bg-white dark:bg-gray-800 shadow-xl rounded-2xl p-6 border border-gray-100 dark:border-gray-700">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="p-2 bg-teal-50 rounded-lg text-teal-600">
                                <svg class="w-6 h-6 font-bold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </div>
                            <h3 class="font-bold text-gray-900 dark:text-gray-100">Service Coverage</h3>
                        </div>
                        <div class="space-y-4">
                            <div class="flex flex-col">
                                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Main Region</span>
                                <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">{{ $user->workerProfile->region ?? 'Tanzania' }}</span>
                            </div>
                            <div class="w-full h-px bg-gray-50"></div>
                            <div class="flex flex-col">
                                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Operating Areas</span>
                                <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">{{ $user->workerProfile->district }}, {{ $user->workerProfile->ward }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Details -->
                <div class="md:col-span-2 space-y-8">
                    
                    <!-- Bio & Experience -->
                    <div class="bg-white dark:bg-gray-800 shadow-xl rounded-2xl p-8 border border-gray-100 dark:border-gray-700">
                        <h3 class="font-bold text-xl text-gray-900 dark:text-gray-100 mb-6 flex items-center gap-2">
                             <svg class="w-6 h-6 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                             Professional Narrative
                        </h3>
                        <div class="prose dark:prose-invert max-w-none text-gray-600 dark:text-gray-300 leading-relaxed mb-8">
                            @if($user->workerProfile->bio)
                                <p class="text-lg italic text-gray-700 leading-relaxed">"{{ $user->workerProfile->bio }}"</p>
                            @else
                                <p class="italic text-gray-400">This professional has not provided a bio yet.</p>
                            @endif
                        </div>

                        @if($user->workerProfile->skills)
                            <div class="mb-8 flex flex-wrap gap-2">
                                @foreach(explode(',', $user->workerProfile->skills) as $skill)
                                    <span class="px-3 py-1 bg-teal-50 dark:bg-teal-900/30 text-teal-700 dark:text-teal-300 text-[10px] font-black rounded-full border border-teal-100 dark:border-teal-800 uppercase tracking-tight">
                                        {{ trim($skill) }}
                                    </span>
                                @endforeach
                            </div>
                        @endif

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div class="bg-gray-50 dark:bg-gray-700/50 p-6 rounded-2xl border border-gray-100 flex items-center gap-4">
                                <div class="w-12 h-12 bg-white rounded-xl shadow-sm flex items-center justify-center text-teal-600">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                </div>
                                <div>
                                    <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest">Experience</span>
                                    <span class="block text-xl font-bold text-gray-900 dark:text-gray-100">{{ $user->workerProfile->experience_years }} Years</span>
                                </div>
                            </div>
                            <div class="bg-gray-50 dark:bg-gray-700/50 p-6 rounded-2xl border border-gray-100 flex items-center gap-4">
                                <div class="w-12 h-12 bg-white rounded-xl shadow-sm flex items-center justify-center text-indigo-600">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <div>
                                    <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest">Base Rate</span>
                                    <span class="block text-xl font-bold text-gray-900 dark:text-gray-100">
                                        {{ $user->workerProfile->price ? number_format($user->workerProfile->price) : 'Negotiable' }} <span class="text-xs font-normal">TZS</span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Portfolio Gallery -->
                    @if($user->workerProfile->portfolioImages->count() > 0)
                        <div class="bg-white dark:bg-gray-800 shadow-xl rounded-2xl p-8 border border-gray-100 dark:border-gray-700">
                             <div class="flex items-center justify-between mb-6">
                                <h3 class="font-bold text-xl text-gray-900 dark:text-gray-100 flex items-center gap-2">
                                     <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h14a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                     Work Gallery
                                </h3>
                                <span class="text-xs font-bold text-gray-400">{{ $user->workerProfile->portfolioImages->count() }} Projects</span>
                             </div>
                             <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                 @foreach($user->workerProfile->portfolioImages as $image)
                                    <div class="relative group aspect-square overflow-hidden rounded-2xl bg-gray-100 ring-1 ring-gray-100">
                                        <img src="{{ asset('storage/' . $image->image_path) }}" class="object-cover w-full h-full transform transition-transform duration-700 group-hover:scale-110" alt="Portfolio Image">
                                        <div class="absolute inset-0 bg-gradient-to-t from-gray-900/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-4">
                                            <span class="text-white text-xs font-bold">Project View</span>
                                        </div>
                                    </div>
                                 @endforeach
                             </div>
                        </div>
                    @endif

                    <!-- Trust & Reviews -->
                    <div class="bg-white dark:bg-gray-800 shadow-xl rounded-2xl p-8 border border-gray-100 dark:border-gray-700">
                         <h3 class="font-bold text-xl text-gray-900 dark:text-gray-100 mb-8 flex items-center gap-2">
                             <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                             Community Trust
                         </h3>
                         
                         <!-- Rating Summary Breakdown -->
                         <div class="grid grid-cols-1 md:grid-cols-2 gap-12 mb-12 items-center bg-gray-50 dark:bg-gray-700/30 p-8 rounded-3xl">
                            <div class="text-center">
                                <div class="text-6xl font-black text-gray-900 dark:text-gray-100 mb-2">
                                    {{ number_format($user->receivedReviews->avg('rating') ?? 5, 1) }}
                                </div>
                                <div class="flex justify-center mb-2">
                                    @php $avg = $user->receivedReviews->avg('rating') ?? 5; @endphp
                                    @for($i=1; $i<=5; $i++)
                                        <svg class="w-6 h-6 {{ $i <= round($avg) ? 'text-yellow-400' : 'text-gray-200' }} fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                    @endfor
                                </div>
                                <div class="text-sm font-bold text-gray-400 uppercase tracking-widest">{{ $user->receivedReviews->count() }} Reviews Total</div>
                            </div>
                            
                            <div class="space-y-3">
                                @foreach([5, 4, 3, 2, 1] as $star)
                                    @php 
                                        $count = $ratingBreakdown[$star] ?? 0;
                                        $percent = $user->receivedReviews->count() > 0 ? ($count / $user->receivedReviews->count()) * 100 : 0;
                                    @endphp
                                    <div class="flex items-center gap-4">
                                        <span class="text-xs font-bold text-gray-500 w-4">{{ $star }}</span>
                                        <div class="flex-grow h-2 bg-gray-200 dark:bg-gray-600 rounded-full overflow-hidden">
                                            <div class="h-full bg-yellow-400 rounded-full" style="width: {{ $percent }}%"></div>
                                        </div>
                                        <span class="text-xs font-bold text-gray-400 w-8 text-right">{{ $count }}</span>
                                    </div>
                                @endforeach
                            </div>
                         </div>

                         <!-- List Reviews -->
                         <div class="space-y-8 mb-12">
                             @forelse($user->receivedReviews->sortByDesc('created_at') as $review)
                                @php
                                    $isVerifiedHire = \App\Models\Request::where('user_id', $review->user_id)
                                        ->where('worker_id', $review->worker_id)
                                        ->where('status', 'completed')
                                        ->exists();
                                @endphp
                                <div class="group">
                                    <div class="flex items-start gap-4">
                                        <div class="w-12 h-12 rounded-full bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600 font-bold group-hover:scale-110 transition-transform">
                                            {{ substr($review->user->name, 0, 1) }}
                                        </div>
                                        <div class="flex-grow">
                                            <div class="flex items-center justify-between mb-1">
                                                <div class="flex items-center gap-2">
                                                    <h4 class="font-bold text-gray-900 dark:text-gray-100">{{ $review->user->name }}</h4>
                                                    @if($isVerifiedHire)
                                                        <span class="flex items-center gap-1 bg-teal-50 text-teal-600 text-[10px] font-black uppercase tracking-widest px-2 py-0.5 rounded-full border border-teal-100">
                                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                                            Verified Hire
                                                        </span>
                                                    @endif
                                                </div>
                                                <span class="text-xs text-gray-400">{{ $review->created_at->format('M d, Y') }}</span>
                                            </div>
                                            <div class="flex items-center mb-3">
                                                @for($i=1; $i<=5; $i++)
                                                    <svg class="w-3.5 h-3.5 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-200' }} fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                                @endfor
                                            </div>
                                            <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed border-l-2 border-gray-100 dark:border-gray-700 pl-4 py-1 italic mb-4">
                                                "{{ $review->comment }}"
                                            </p>

                                            @if($review->image_path)
                                                <div class="mt-4 mb-4">
                                                    <a href="{{ asset('storage/' . $review->image_path) }}" target="_blank" class="block w-32 h-32 rounded-xl overflow-hidden border-2 border-gray-50 hover:border-teal-500 transition-colors shadow-sm">
                                                        <img src="{{ asset('storage/' . $review->image_path) }}" class="w-full h-full object-cover transform hover:scale-110 transition-transform" alt="Review Evidence">
                                                    </a>
                                                </div>
                                            @endif

                                            <!-- Worker Reply Section -->
                                            @if($review->reply)
                                                <div class="mt-4 bg-gray-50 dark:bg-gray-800/50 p-4 rounded-2xl border-l-4 border-teal-500 relative">
                                                    <div class="flex items-center gap-2 mb-2">
                                                        <span class="text-[10px] font-black text-teal-600 uppercase tracking-widest">Worker Response</span>
                                                        <span class="text-[9px] text-gray-400">{{ $review->replied_at->diffForHumans() }}</span>
                                                    </div>
                                                    <p class="text-sm text-gray-700 dark:text-gray-300 font-medium leading-relaxed">
                                                        {{ $review->reply }}
                                                    </p>
                                                </div>
                                            @elseif(Auth::id() === $user->id)
                                                <div x-data="{ replying: false }" class="mt-2">
                                                    <button @click="replying = true" x-show="!replying" class="text-[10px] font-black text-teal-600 uppercase tracking-widest hover:underline">Reply to this review</button>
                                                    
                                                    <div x-show="replying" x-cloak class="mt-2 animate-fade-in">
                                                        <form action="{{ route('reviews.reply', $review->id) }}" method="POST">
                                                            @csrf
                                                            <textarea name="reply" placeholder="Write your professional thank you or response..." class="w-full rounded-xl border-gray-200 text-sm py-2 mb-2 focus:ring-teal-500" rows="2" required></textarea>
                                                            <div class="flex gap-2">
                                                                <button type="submit" class="bg-teal-600 text-white text-[10px] font-black uppercase tracking-widest px-4 py-1.5 rounded-lg shadow-sm">Send Reply</button>
                                                                <button type="button" @click="replying = false" class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Cancel</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-12 bg-gray-50 dark:bg-gray-700/50 rounded-3xl border-2 border-dashed border-gray-100 dark:border-gray-600">
                                     <p class="text-gray-400 italic">No community feedback yet. Be the first to review!</p>
                                </div>
                            @endforelse
                         </div>

                         <!-- Review Form -->
                         @auth
                            @if(Auth::id() !== $user->id)
                                <div class="bg-gray-900 text-white p-8 rounded-3xl shadow-2xl relative overflow-hidden">
                                     <div class="absolute top-0 right-0 -mr-16 -mt-16 w-48 h-48 bg-teal-500/20 rounded-full blur-3xl"></div>
                                    <h4 class="font-bold text-xl mb-6 relative z-10">Rate your experience</h4>
                                    <form action="{{ route('reviews.store', $user->id) }}" method="POST" enctype="multipart/form-data" class="relative z-10">
                                        @csrf
                                        
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                            <div>
                                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Star Rating</label>
                                                <select name="rating" class="w-full rounded-xl bg-gray-800 border-gray-700 text-white focus:ring-teal-500 focus:border-teal-500 py-3 shadow-inner">
                                                    <option value="5">Excellent — 5 Stars</option>
                                                    <option value="4">Great — 4 Stars</option>
                                                    <option value="3">Okay — 3 Stars</option>
                                                    <option value="2">Poor — 2 Stars</option>
                                                    <option value="1">Terrible — 1 Star</option>
                                                </select>
                                            </div>
                                            <div>
                                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Proof of Work (Optional)</label>
                                                <input type="file" name="review_image" accept="image/*" class="w-full text-xs text-gray-400 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-[10px] file:font-black file:uppercase file:bg-teal-500/20 file:text-teal-400 hover:file:bg-teal-500/30 transition-all cursor-pointer bg-gray-800 rounded-xl border border-gray-700 p-1.5">
                                            </div>
                                        </div>

                                        <div class="mb-6">
                                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Review Comment</label>
                                            <textarea name="comment" rows="3" class="w-full rounded-xl bg-gray-800 border-gray-700 text-white focus:ring-teal-500 focus:border-teal-500 py-3 shadow-inner" placeholder="What was the highlight of the service?"></textarea>
                                        </div>

                                        <button type="submit" class="px-8 py-3 bg-teal-500 hover:bg-teal-400 text-gray-900 font-black rounded-xl transition-all shadow-lg active:scale-95">
                                            Post Review
                                        </button>
                                    </form>
                                </div>
                            @endif
                         @else
                            <div class="text-center p-8 bg-gray-50 dark:bg-gray-700/50 rounded-3xl border border-gray-100">
                                <p class="text-gray-600 text-sm">Join the community to share your feedback. <a href="{{ route('login') }}" class="font-bold text-indigo-600 hover:underline">Sign in now</a>.</p>
                            </div>
                         @endauth
                    </div>
                    
                </div>
            </div>
        </div>
    </div>

    <!-- Request Modal Logic (Simple Toggle) -->
    <div x-data="{ open: false }" @keydown.escape.window="open = false">
        <!-- Trigger Button (Fixed at bottom on mobile, inline on desktop) -->
        <div class="fixed bottom-0 left-0 w-full p-4 bg-white border-t border-gray-200 md:hidden z-40">
            <button @click="open = !open" class="w-full py-3 bg-gray-900 text-white font-bold rounded-lg shadow-lg">
                Request Service
            </button>
        </div>
        
        <!-- Desktop Trigger (in location card) -->
        <script>
            // Simple script to duplicate button functionality if needed or rely on x-data in parent
        </script>

        <!-- Modal Overlay -->
        <div x-show="open" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity" @click="open = false"></div>

            <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                    <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                        <h3 class="text-lg font-semibold leading-6 text-gray-900 mb-4">Request Service from {{ $user->name }}</h3>
                        
                        <form action="{{ route('requests.store', $user->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2 uppercase tracking-widest text-[10px]">When do you need help?</label>
                                <input type="date" name="requested_date" class="w-full rounded-xl border-gray-200 bg-gray-50 focus:border-teal-500 focus:ring-4 focus:ring-teal-500/10 transition-all py-2.5">
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2 uppercase tracking-widest text-[10px]">Describe what you need</label>
                                <textarea name="message" rows="4" class="w-full rounded-xl border-gray-200 bg-gray-50 focus:border-teal-500 focus:ring-4 focus:ring-teal-500/10 transition-all py-2.5" placeholder="E.g. My sink is leaking and I need it fixed ASAP..." required></textarea>
                            </div>

                            <div class="mb-6">
                                <label class="block text-gray-700 text-sm font-bold mb-2 uppercase tracking-widest text-[10px]">Attach Photo (Optional)</label>
                                <div class="relative group">
                                    <input type="file" name="request_image" accept="image/*" class="w-full text-xs text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-[10px] file:font-black file:uppercase file:bg-gray-900 file:text-white hover:file:bg-teal-600 transition-all cursor-pointer bg-gray-50 rounded-xl border border-dashed border-gray-300 p-2">
                                    <p class="text-[10px] text-gray-400 mt-1 italic">Adding a photo helps the worker give a more accurate estimate.</p>
                                </div>
                            </div>

                             <div class="mt-5 sm:mt-6 sm:grid sm:grid-flow-row-dense sm:grid-cols-2 sm:gap-3">
                                <button type="submit" class="inline-flex w-full justify-center rounded-xl bg-gray-900 px-3 py-3 text-sm font-black text-white shadow-lg hover:bg-teal-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-teal-600 sm:col-start-2 transition-all active:scale-95 uppercase tracking-widest">Send Request</button>
                                <button type="button" @click="open = false" class="mt-3 inline-flex w-full justify-center rounded-xl bg-white px-3 py-3 text-sm font-black text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:col-start-1 sm:mt-0 uppercase tracking-widest">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Flash Message for Request Sent -->
         @if (session('status') === 'request-sent')
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-xl z-50 animate-bounce">
                Request Sent Successfully!
            </div>
        @endif
    </div>
@endsection
