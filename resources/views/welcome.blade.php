<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'MtaaLink') }} - Connect with Social Works</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&display=swap" rel="stylesheet" />
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .hero-pattern {
            background-image: radial-gradient(#14b8a6 1px, transparent 1px);
            background-size: 24px 24px;
            opacity: 0.1;
        }
    </style>
</head>
<body class="antialiased text-gray-800 bg-gray-50 selection:bg-teal-500 selection:text-white">

    <!-- Navigation -->
    <nav class="fixed w-full z-50 glass transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <!-- Logo -->
                <a href="{{ route('welcome') }}" class="flex-shrink-0 flex items-center gap-2 group">
                    <div class="w-10 h-10 bg-gradient-to-br from-teal-500 to-blue-600 rounded-xl flex items-center justify-center text-white font-bold text-xl shadow-lg shadow-teal-500/30 transition-transform group-hover:scale-110">
                        M
                    </div>
                    <span class="font-bold text-2xl tracking-tight text-gray-900">Mtaa<span class="text-teal-600">Link</span></span>
                </a>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#how-it-works" class="text-gray-600 hover:text-teal-600 font-medium transition-colors">How it Works</a>
                    <a href="{{ route('search.index') }}" class="text-gray-600 hover:text-teal-600 font-medium transition-colors">Find Help</a>
                    <a href="{{ route('register') }}" class="text-gray-600 hover:text-teal-600 font-medium transition-colors">Join as Worker</a>
                </div>

                <!-- Auth Buttons -->
                <div class="hidden md:flex items-center gap-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="font-semibold text-gray-600 hover:text-gray-900 transition-colors">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="font-medium text-gray-600 hover:text-gray-900 transition-colors">Log in</a>
                        <a href="{{ route('register') }}" class="px-5 py-2.5 bg-gray-900 text-white font-semibold rounded-full hover:bg-gray-800 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                            Sign Up
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden bg-white">
        <!-- Background Elements -->
        <div class="absolute inset-0 hero-pattern"></div>
        <div class="absolute top-20 right-0 -mr-20 w-96 h-96 bg-teal-200 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-float"></div>
        <div class="absolute bottom-0 left-0 -ml-20 w-80 h-80 bg-blue-200 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-float delay-1000"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <!-- Text Content -->
                <div class="max-w-2xl animate-fade-in-up">
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-teal-50 border border-teal-100 text-teal-700 font-bold text-xs uppercase tracking-wider mb-6">
                        <span class="w-2 h-2 rounded-full bg-teal-500 animate-pulse"></span>
                        #1 Social Work Platform in Tanzania
                    </div>
                    
                    <h1 class="text-5xl lg:text-7xl font-extrabold tracking-tight text-gray-900 mb-6 leading-[1.1]">
                        Reliable Help in <br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-teal-500 to-blue-600">Your Neighborhood</span>
                    </h1>
                    
                    <p class="text-lg text-gray-600 mb-8 leading-relaxed">
                        Connect with verified social workers, cleaners, caregivers, and skilled experts directly in your <strong>Mtaa</strong>. Safe, fast, and community-driven.
                    </p>

                    <!-- Hero Search Box -->
                    <form action="{{ route('search.index') }}" method="GET" class="bg-white p-2 rounded-2xl shadow-xl shadow-gray-200/50 border border-gray-100 flex flex-col sm:flex-row gap-2 max-w-xl mb-8 group focus-within:ring-2 focus-within:ring-teal-500/20 transition-all">
                        <div class="flex-[1.5] relative">
                            <svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            <input type="text" name="query" placeholder="What help do you need?" class="w-full pl-10 pr-4 py-3 border-none rounded-xl focus:ring-0 text-gray-900 placeholder-gray-500 bg-transparent">
                        </div>
                        <div class="w-px bg-gray-200 hidden sm:block my-2"></div>
                        <div class="flex-1 relative">
                             <svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <input type="text" name="ward" placeholder="Your Mtaa" class="w-full pl-10 pr-4 py-3 border-none rounded-xl focus:ring-0 text-gray-900 placeholder-gray-500 bg-transparent">
                        </div>
                        <button type="submit" class="bg-gray-900 hover:bg-teal-600 text-white font-bold py-3 px-8 rounded-xl transition-all flex items-center justify-center shadow-lg active:scale-95">
                            Find Help
                        </button>
                    </form>

                    <!-- Trust Indicators -->
                    <div class="flex items-center gap-8 animate-fade-in delay-500">
                        <div class="flex flex-col">
                            <span class="text-2xl font-bold text-gray-900">{{ \App\Models\User::where('role', 'worker')->count() }}+</span>
                            <span class="text-xs font-semibold text-gray-400 uppercase tracking-widest">Verified Pros</span>
                        </div>
                        <div class="w-px h-10 bg-gray-200"></div>
                        <div class="flex flex-col">
                            <span class="text-2xl font-bold text-gray-900">98%</span>
                            <span class="text-xs font-semibold text-gray-400 uppercase tracking-widest">Job Success</span>
                        </div>
                        <div class="w-px h-10 bg-gray-200"></div>
                        <div class="flex flex-col">
                            <span class="text-2xl font-bold text-gray-900">{{ \App\Models\Request::count() }}+</span>
                            <span class="text-xs font-semibold text-gray-400 uppercase tracking-widest">Requests</span>
                        </div>
                    </div>
                </div>
                    <div class="flex items-center gap-6 text-sm font-medium text-gray-500">
                        <div class="flex items-center gap-1">
                            <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                            Verified Workers
                        </div>
                        <div class="flex items-center gap-1">
                            <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                            Free to Join
                        </div>
                    </div>
                </div>

                <!-- Visual Content -->
                <div class="relative lg:h-[600px] flex items-center justify-center animate-fade-in-up delay-200">
                    <div class="relative z-10 w-full max-w-md bg-white rounded-2xl shadow-2xl p-6 border border-gray-100 transform rotate-2">
                        <!-- Mockup Profile -->
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-16 h-16 rounded-full bg-gray-200 overflow-hidden">
                                <div class="w-full h-full bg-gradient-to-br from-indigo-400 to-purple-500"></div>
                            </div>
                            <div>
                                <h3 class="font-bold text-lg text-gray-900">Juma H.</h3>
                                <p class="text-teal-600 text-sm font-medium">Professional Plumber</p>
                                <div class="flex text-yellow-400 text-xs mt-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                    <span class="text-gray-400 ml-1">(42 Reviews)</span>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-xl mb-4">
                            <p class="text-gray-600 text-sm">"Juma arrived on time and fixed my sink in 20 minutes. Highly recommended for anyone in Kinondoni!"</p>
                        </div>
                        <div class="flex justify-between items-center">
                             <span class="text-gray-900 font-bold">15,000 TZS</span>
                             <button class="px-4 py-2 bg-gray-900 text-white text-sm font-bold rounded-lg shadow-lg">Request</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    
    <!-- Featured Professionals -->
    @if(isset($featuredWorkers) && $featuredWorkers->count() > 0)
    <section class="py-16 bg-white border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-yellow-50 text-yellow-700 font-bold text-xs uppercase tracking-wider mb-4">
                    <svg class="w-4 h-4 text-yellow-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                    Top Rated
                </div>
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Featured Professionals</h2>
                <p class="text-gray-600">Highly recommended workers in your area</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($featuredWorkers as $worker)
                    <div class="bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 overflow-hidden group">
                        <div class="relative h-48 overflow-hidden bg-gray-200">
                            @if($worker->portfolioImages->first())
                                <img src="{{ asset('storage/' . $worker->portfolioImages->first()->image_path) }}" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-teal-400 to-blue-500"></div>
                            @endif
                            
                            <div class="absolute bottom-0 left-0 w-full p-4 bg-gradient-to-t from-black/80 to-transparent">
                                <span class="bg-white/20 backdrop-blur-sm text-white text-xs font-bold px-2 py-1 rounded">
                                    {{ $worker->service->name }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="p-5">
                            <div class="flex items-center justify-between mb-3">
                                <h3 class="font-bold text-lg text-gray-900 truncate">{{ $worker->user->name }}</h3>
                                <div class="flex items-center text-yellow-400 text-sm font-bold">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                    {{ number_format($worker->user->receivedReviews->avg('rating') ?? 5, 1) }}
                                </div>
                            </div>
                            
                            <p class="text-sm text-gray-500 mb-4 line-clamp-2">
                                {{ $worker->bio ? Str::limit($worker->bio, 80) : 'Professional service provider ready to help you.' }}
                            </p>
                            
                            <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                                <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">{{ $worker->district ?? 'Dar es Salaam' }}</span>
                                <a href="{{ route('worker.show', $worker->user->id) }}" class="text-sm font-bold text-teal-600 hover:text-teal-800 flex items-center">
                                    View Profile <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="mt-10 text-center">
                <a href="{{ route('search.index') }}" class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-full text-teal-700 bg-teal-100 hover:bg-teal-200 transition-colors">
                    View All Professionals
                </a>
            </div>
        </div>
    </section>
    @endif

    <!-- Popular Categories -->
    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
             <div class="text-center mb-12 animate-fade-in-up">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Popular Services</h2>
                <p class="text-gray-600">Find the right professional for your needs</p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
                <!-- Category Item -->
                <a href="{{ route('search.index') }}?service=1" class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md hover:border-teal-200 transition-all text-center group">
                    <div class="w-12 h-12 mx-auto bg-teal-50 text-teal-600 rounded-xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                    </div>
                    <span class="font-semibold text-gray-700 group-hover:text-teal-600">Cleaning</span>
                </a>

                 <a href="{{ route('search.index') }}?service=5" class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md hover:border-blue-200 transition-all text-center group">
                    <div class="w-12 h-12 mx-auto bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <span class="font-semibold text-gray-700 group-hover:text-blue-600">Electrical</span>
                </a>

                 <a href="{{ route('search.index') }}?service=4" class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md hover:border-indigo-200 transition-all text-center group">
                    <div class="w-12 h-12 mx-auto bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <span class="font-semibold text-gray-700 group-hover:text-indigo-600">Plumbing</span>
                </a>

                 <a href="{{ route('search.index') }}?service=8" class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md hover:border-pink-200 transition-all text-center group">
                    <div class="w-12 h-12 mx-auto bg-pink-50 text-pink-600 rounded-xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                    </div>
                    <span class="font-semibold text-gray-700 group-hover:text-pink-600">Elderly Care</span>
                </a>

                 <a href="{{ route('search.index') }}?service=2" class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md hover:border-purple-200 transition-all text-center group">
                    <div class="w-12 h-12 mx-auto bg-purple-50 text-purple-600 rounded-xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                    <span class="font-semibold text-gray-700 group-hover:text-purple-600">Tutoring</span>
                </a>

                 <a href="{{ route('search.index') }}?service=9" class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md hover:border-orange-200 transition-all text-center group">
                    <div class="w-12 h-12 mx-auto bg-orange-50 text-orange-600 rounded-xl flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                         <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    </div>
                    <span class="font-semibold text-gray-700 group-hover:text-orange-600">View All</span>
                </a>
            </div>
        </div>
    </section>

    <!-- How It Works & Stats -->
    <section class="py-24 bg-white relative overflow-hidden" id="how-it-works">
        <div class="absolute inset-0 hero-pattern opacity-50"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="grid md:grid-cols-2 gap-16 items-center">
                <!-- Steps -->
                <div>
                     <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50 text-blue-700 font-bold text-xs uppercase tracking-wider mb-6">
                        Easy Process
                    </div>
                    <h2 class="text-4xl font-extrabold text-gray-900 mb-6">How MtaaLink Works</h2>
                    <p class="text-lg text-gray-600 mb-8">We've made it incredibly simple to find and hire help in Tanzania.</p>
                    
                    <div class="space-y-8">
                        <div class="flex gap-4">
                            <div class="flex-shrink-0 w-10 h-10 rounded-full bg-teal-100 flex items-center justify-center text-teal-600 font-bold text-lg">1</div>
                            <div>
                                <h3 class="font-bold text-xl text-gray-900">Search Nearby</h3>
                                <p class="text-gray-600 mt-1">Enter your location (Street/Mtaa) to find workers around you.</p>
                            </div>
                        </div>
                         <div class="flex gap-4">
                            <div class="flex-shrink-0 w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-lg">2</div>
                            <div>
                                <h3 class="font-bold text-xl text-gray-900">Select & Connect</h3>
                                <p class="text-gray-600 mt-1">View profiles, check ratings, and call or WhatsApp directly.</p>
                            </div>
                        </div>
                         <div class="flex gap-4">
                            <div class="flex-shrink-0 w-10 h-10 rounded-full bg-purple-100 flex items-center justify-center text-purple-600 font-bold text-lg">3</div>
                            <div>
                                <h3 class="font-bold text-xl text-gray-900">Get it Done</h3>
                                <p class="text-gray-600 mt-1">Service is delivered. Pay the worker directly. Leave a review.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Stats Card -->
                <div class="bg-gray-900 rounded-3xl p-8 lg:p-12 text-white relative shadow-2xl overflow-hidden">
                    <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 bg-teal-500 rounded-full blur-3xl opacity-20"></div>
                    <div class="absolute bottom-0 left-0 -ml-16 -mb-16 w-64 h-64 bg-blue-500 rounded-full blur-3xl opacity-20"></div>

                    <div class="relative z-10 grid grid-cols-2 gap-8 text-center border-b border-gray-700 pb-8 mb-8">
                        <div>
                            <div class="text-4xl font-extrabold text-teal-400 mb-1">500+</div>
                            <div class="text-gray-400 text-sm font-medium">Verified Workers</div>
                        </div>
                         <div>
                            <div class="text-4xl font-extrabold text-blue-400 mb-1">20+</div>
                            <div class="text-gray-400 text-sm font-medium">Regions Covered</div>
                        </div>
                    </div>
                    <div class="relative z-10 text-center">
                        <div class="text-5xl font-extrabold text-white mb-2">1,200+</div>
                        <div class="text-gray-400 font-medium">Successful Connections Made</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-100 pt-16 pb-8">
         <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-8 mb-12">
                <div class="col-span-1 md:col-span-1">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-8 h-8 bg-gray-900 rounded-lg flex items-center justify-center text-white font-bold text-sm">M</div>
                        <span class="font-bold text-xl text-gray-900">MtaaLink</span>
                    </div>
                    <p class="text-gray-500 text-sm leading-relaxed">Connecting Tanzanian communities with trusted local help, one Mtaa at a time.</p>
                </div>
                
                <div>
                    <h4 class="font-bold text-gray-900 mb-4">Product</h4>
                    <ul class="space-y-2 text-sm text-gray-600">
                        <li><a href="#" class="hover:text-teal-600">Find Workers</a></li>
                        <li><a href="#" class="hover:text-teal-600">List Services</a></li>
                        <li><a href="#" class="hover:text-teal-600">Pricing</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-bold text-gray-900 mb-4">Company</h4>
                    <ul class="space-y-2 text-sm text-gray-600">
                        <li><a href="#" class="hover:text-teal-600">About Us</a></li>
                        <li><a href="#" class="hover:text-teal-600">Contact</a></li>
                        <li><a href="#" class="hover:text-teal-600">Privacy Policy</a></li>
                    </ul>
                </div>

                 <div>
                    <h4 class="font-bold text-gray-900 mb-4">Social</h4>
                    <div class="flex gap-4">
                        <a href="#" class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-600 hover:bg-teal-50 hover:text-teal-600 transition-colors">
                            <span class="sr-only">Twitter</span>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"></path></svg>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-600 hover:bg-teal-50 hover:text-teal-600 transition-colors">
                             <span class="sr-only">Instagram</span>
                             <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.468 2.3c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd"></path></svg>
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="border-t border-gray-100 pt-8 flex flex-col md:flex-row justify-between items-center text-sm text-gray-500">
                <p>&copy; {{ date('Y') }} MtaaLink. All rights reserved.</p>
                <div class="flex gap-6 mt-4 md:mt-0">
                    <a href="#" class="hover:text-gray-900">Privacy</a>
                    <a href="#" class="hover:text-gray-900">Terms</a>
                    <a href="#" class="hover:text-gray-900">Sitemap</a>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
