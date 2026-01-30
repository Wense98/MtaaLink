<x-guest-layout>
    <div class="relative">
        <div class="mb-10 text-left">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-orange-50 text-orange-600 font-bold text-[10px] uppercase tracking-widest mb-4 border border-orange-100">
                Account Recovery
            </div>
            <h2 class="text-4xl font-black text-gray-900 mb-2 tracking-tight">Lost Access?</h2>
            <p class="text-gray-500 font-medium text-lg leading-relaxed">No worries. Enter your email and we'll send a secure link to reset your identity.</p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-6" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}" class="space-y-8">
            @csrf

            <!-- Email Address -->
            <div class="group">
                <label for="email" class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3 ml-1 group-focus-within:text-teal-600 transition-colors">Registered Email</label>
                <div class="relative">
                    <input id="email" class="block w-full rounded-2xl border-gray-100 bg-gray-50/50 focus:border-teal-500 focus:ring-4 focus:ring-teal-500/10 focus:bg-white shadow-sm pl-14 pr-4 py-4.5 transition-all duration-300 font-bold text-gray-700 placeholder:text-gray-300" type="email" name="email" :value="old('email')" required autofocus placeholder="name@email.com" />
                    <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-gray-400 group-focus-within:text-teal-600 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="pt-4">
                <button type="submit" class="group relative w-full flex justify-center py-5 px-6 border border-transparent text-sm font-black rounded-2xl text-white bg-gray-900 hover:bg-teal-600 focus:outline-none focus:ring-4 focus:ring-teal-500/20 transition-all duration-300 uppercase tracking-[0.15em] shadow-2xl hover:shadow-teal-500/40 active:scale-95">
                    <span class="relative z-10 flex items-center gap-2">
                        {{ __('Send Recovery Link') }}
                        <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                    </span>
                </button>
            </div>

            <div class="text-center pt-8 border-t border-gray-100 mt-8">
                <a href="{{ route('login') }}" class="text-xs font-black text-gray-400 hover:text-teal-600 uppercase tracking-widest transition-colors flex items-center justify-center gap-2 group">
                    <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back to Sign In
                </a>
            </div>
        </form>
    </div>
</x-guest-layout>
