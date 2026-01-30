<x-guest-layout>
    <div class="mb-8 text-center">
        <h2 class="text-2xl font-bold text-gray-900 mb-2">Create Account</h2>
        <p class="text-gray-500">Join the MtaaLink community today.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" class="space-y-6" x-data="{ role: 'customer' }">
        @csrf

        <!-- Role Selection -->
        <div class="space-y-2">
            <x-input-label :value="__('I am a...')" />
            <div class="grid grid-cols-2 gap-4">
                <label class="flex items-center justify-center p-3 border-2 rounded-xl cursor-pointer transition-all peer-checked:border-teal-500" :class="role === 'customer' ? 'border-teal-500 bg-teal-50' : 'border-gray-200'">
                    <input type="radio" name="role" value="customer" class="sr-only" x-model="role">
                    <span class="text-sm font-bold" :class="role === 'customer' ? 'text-teal-700' : 'text-gray-600'">Customer</span>
                </label>
                <label class="flex items-center justify-center p-3 border-2 rounded-xl cursor-pointer transition-all" :class="role === 'worker' ? 'border-teal-500 bg-teal-50' : 'border-gray-200'">
                    <input type="radio" name="role" value="worker" class="sr-only" x-model="role">
                    <span class="text-sm font-bold" :class="role === 'worker' ? 'text-teal-700' : 'text-gray-600'">Worker</span>
                </label>
            </div>
        </div>

        <div class="space-y-4">
            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Full Name')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus placeholder="e.g. Salim Rashid" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required placeholder="email@ext.com" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="phone" :value="__('Phone Number')" />
                    <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')" required placeholder="07XXXXXXXX" />
                    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                </div>
            </div>

            <!-- Location Fields (Only for Workers) -->
            <div x-show="role === 'worker'" x-transition class="space-y-4 pt-2 border-t border-gray-100 mt-4">
                <p class="text-xs font-black text-gray-400 uppercase tracking-widest mb-4">Location Information (Worker Only)</p>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="region" :value="__('Region (Mkoa)')" />
                        <x-text-input id="region" class="block mt-1 w-full" type="text" name="region" :value="old('region')" placeholder="e.g. Dar es Salaam" />
                        <x-input-error :messages="$errors->get('region')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="district" :value="__('District (Wilaya)')" />
                        <x-text-input id="district" class="block mt-1 w-full" type="text" name="district" :value="old('district')" placeholder="e.g. Kinondoni" />
                        <x-input-error :messages="$errors->get('district')" class="mt-2" />
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="ward" :value="__('Ward (Kata)')" />
                        <x-text-input id="ward" class="block mt-1 w-full" type="text" name="ward" :value="old('ward')" placeholder="e.g. Hananasif" />
                        <x-input-error :messages="$errors->get('ward')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="street" :value="__('Street (Mtaa)')" />
                        <x-text-input id="street" class="block mt-1 w-full" type="text" name="street" :value="old('street')" placeholder="e.g. Mkunguni" />
                        <x-input-error :messages="$errors->get('street')" class="mt-2" />
                    </div>
                </div>
            </div>

            <!-- Password -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                    <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>
            </div>
        </div>

        <div class="pt-4">
            <x-primary-button class="w-full justify-center py-3 bg-gray-900 hover:bg-teal-600">
                {{ __('Register Now') }}
            </x-primary-button>
        </div>

        <div class="text-center text-sm text-gray-600 mt-6">
            {{ __('Already registered?') }}
            <a href="{{ route('login') }}" class="font-bold text-teal-600 hover:text-teal-700 ml-1">
                {{ __('Log in') }}
            </a>
        </div>
    </form>
</x-guest-layout>
