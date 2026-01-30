<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Messages') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-100 dark:border-gray-700">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-bold mb-6 italic text-teal-600">Your Conversations</h3>
                    
                    <div class="divide-y divide-gray-100 dark:divide-gray-700">
                        @forelse($users as $user)
                            <a href="{{ route('chat.show', $user->id) }}" class="flex items-center p-4 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors rounded-xl mb-2">
                                <div class="relative">
                                    <div class="w-12 h-12 rounded-full bg-teal-100 flex items-center justify-center text-teal-600 font-bold border-2 border-teal-50">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                    @php
                                        $unreadCount = \App\Models\Message::where('sender_id', $user->id)
                                            ->where('receiver_id', Auth::id())
                                            ->where('is_read', false)
                                            ->count();
                                    @endphp
                                    @if($unreadCount > 0)
                                        <span class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] font-black w-5 h-5 rounded-full flex items-center justify-center shadow-lg border-2 border-white">
                                            {{ $unreadCount }}
                                        </span>
                                    @endif
                                </div>
                                <div class="ml-4 flex-1">
                                    <h4 class="font-bold text-gray-900 dark:text-gray-100">{{ $user->name }}</h4>
                                    <p class="text-xs text-gray-400 font-bold uppercase tracking-widest">{{ $user->role }}</p>
                                </div>
                                <div class="text-gray-300">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </div>
                            </a>
                        @empty
                            <div class="text-center py-12">
                                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-50 mb-4">
                                    <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                                </div>
                                <p class="text-gray-500 font-medium">No messages yet. Start a conversation with a professional!</p>
                                <a href="{{ route('search.index') }}" class="mt-4 inline-block text-teal-600 font-bold text-sm hover:underline">Find Workers</a>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
