<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Chat with {{ $otherUser->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100 dark:border-gray-700 flex flex-col h-[600px]">
                
                <!-- Chat Header -->
                <div class="p-4 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between bg-gray-50/50">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-teal-100 flex items-center justify-center text-teal-600 font-bold border border-teal-200 shadow-sm">
                            {{ substr($otherUser->name, 0, 1) }}
                        </div>
                        <div>
                            <h3 class="font-black text-gray-900 dark:text-gray-100 leading-none">{{ $otherUser->name }}</h3>
                            <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ $otherUser->role }}</span>
                        </div>
                    </div>
                    @if($otherUser->role === 'worker')
                        <a href="{{ route('worker.show', $otherUser->id) }}" class="text-xs font-black text-teal-600 hover:text-teal-700 uppercase tracking-widest bg-white px-3 py-1.5 rounded-lg border border-teal-100 shadow-sm transition-all">View Profile</a>
                    @endif
                </div>

                <!-- Messages area -->
                <div class="flex-1 overflow-y-auto p-6 space-y-4 bg-gray-50/10" id="messages-container">
                    @forelse($messages as $message)
                        <div class="flex {{ $message->sender_id === Auth::id() ? 'justify-end' : 'justify-start' }}">
                            <div class="max-w-[70%] {{ $message->sender_id === Auth::id() ? 'bg-gray-900 text-white rounded-2xl rounded-tr-none' : 'bg-white text-gray-800 rounded-2xl rounded-tl-none border border-gray-100 shadow-sm' }} p-4">
                                <p class="text-sm font-medium leading-relaxed">{{ $message->message }}</p>
                                <span class="block text-[9px] mt-1 opacity-50 font-bold text-right">{{ $message->created_at->format('H:i') }}</span>
                            </div>
                        </div>
                    @empty
                        <div class="h-full flex flex-col items-center justify-center text-gray-400 italic">
                            <p class="text-sm">No messages yet. Say hi to {{ $otherUser->name }}!</p>
                        </div>
                    @endforelse
                </div>

                <!-- Message Input -->
                <div class="p-4 border-t border-gray-100 dark:border-gray-700 bg-white">
                    <form action="{{ route('chat.store', $otherUser->id) }}" method="POST" class="flex gap-4">
                        @csrf
                        <input type="text" name="message" required placeholder="Type your message here..." class="flex-1 rounded-xl border-gray-100 bg-gray-50/50 focus:border-teal-500 focus:ring-4 focus:ring-teal-500/10 transition-all font-medium py-3 px-5" autocomplete="off">
                        <button type="submit" class="bg-gray-900 hover:bg-teal-600 text-white p-3 rounded-xl transition-all shadow-lg active:scale-90 flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <script>
        // Scroll to bottom of chat
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('messages-container');
            container.scrollTop = container.scrollHeight;
        });
    </script>
</x-app-layout>
