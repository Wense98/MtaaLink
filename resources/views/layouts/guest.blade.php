<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'MtaaLink') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body { 
                font-family: 'Outfit', sans-serif; 
                background: radial-gradient(circle at top right, #f0fdfa, #ffffff);
            }
            .auth-card {
                background: rgba(255, 255, 255, 0.8);
                backdrop-filter: blur(20px);
                border: 1px solid rgba(229, 231, 235, 0.5);
            }
        </style>
    </head>
    <body class="antialiased text-gray-900 bg-gray-50 min-h-screen flex flex-col">
        <div class="flex-1 flex flex-col justify-center items-center p-6">
            <div class="w-full max-w-lg space-y-8">
                <!-- Logo -->
                <div class="text-center mb-10">
                    <a href="{{ route('welcome') }}" class="inline-flex items-center gap-3">
                        <div class="w-12 h-12 bg-gray-900 rounded-xl flex items-center justify-center text-white font-bold text-xl">M</div>
                        <span class="text-2xl font-bold text-gray-900 tracking-tight">Mtaa<span class="text-teal-600">Link</span></span>
                    </a>
                </div>

                <!-- Card -->
                <div class="bg-white p-8 lg:p-12 rounded-3xl shadow-xl shadow-gray-200/50 border border-gray-100">
                    {{ $slot }}
                </div>

                <!-- Footnote -->
                <div class="text-center">
                    <p class="text-xs text-gray-400 font-bold uppercase tracking-widest">
                        &copy; {{ date('Y') }} MtaaLink. Verified Social Workforce.
                    </p>
                </div>
            </div>
        </div>
    </body>
</html>
