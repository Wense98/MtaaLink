<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Verification Requests') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-3xl border border-gray-100 dark:border-gray-700">
                <div class="p-8">
                    <div class="flex justify-between items-center mb-8">
                        <div>
                            <h3 class="text-2xl font-black text-gray-900 dark:text-white">Pending Requests</h3>
                            <p class="text-sm text-gray-400 mt-1 uppercase tracking-widest font-bold">Review applications carefully</p>
                        </div>
                        <span class="bg-teal-50 text-teal-700 text-xs font-black px-4 py-2 rounded-full border border-teal-100 uppercase tracking-widest">
                            {{ $requests->total() }} Remaining
                        </span>
                    </div>

                    @if($requests->isEmpty())
                        <div class="text-center py-20 bg-gray-50 rounded-3xl border border-dashed border-gray-200">
                             <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                             <p class="mt-4 text-gray-500 font-bold uppercase tracking-widest text-xs">All caught up! No pending verifications.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-100 dark:divide-gray-700">
                                <thead>
                                    <tr class="bg-gray-50 dark:bg-gray-900/50">
                                        <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Worker</th>
                                        <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">ID Details</th>
                                        <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Document</th>
                                        <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Submitted</th>
                                        <th class="px-6 py-4 text-right text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50 dark:divide-gray-700">
                                    @foreach($requests as $request)
                                        <tr class="hover:bg-gray-50/50 transition-colors group">
                                            <td class="px-6 py-5 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="h-10 w-10 flex-shrink-0 rounded-xl bg-teal-500 flex items-center justify-center text-white font-bold text-sm shadow-lg shadow-teal-500/20">
                                                        {{ substr($request->user->name, 0, 1) }}
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-bold text-gray-900 group-hover:text-teal-600 transition-colors">{{ $request->user->name }}</div>
                                                        <div class="text-[10px] text-gray-400 font-black uppercase tracking-widest">{{ $request->user->workerProfile->service->name ?? 'Service N/A' }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-5 whitespace-nowrap">
                                                <div class="text-xs font-bold text-gray-700">{{ $request->id_type }}</div>
                                                <div class="text-xs text-gray-400 font-medium">{{ $request->id_number }}</div>
                                            </td>
                                            <td class="px-6 py-5 whitespace-nowrap">
                                                <a href="{{ asset('storage/' . $request->document_path) }}" target="_blank" class="inline-flex items-center gap-2 text-xs font-bold text-teal-600 hover:text-teal-800">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                                    View Document
                                                </a>
                                            </td>
                                            <td class="px-6 py-5 whitespace-nowrap">
                                                <div class="text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ $request->created_at->diffForHumans() }}</div>
                                            </td>
                                            <td class="px-6 py-5 whitespace-nowrap text-right text-sm font-medium">
                                                <div class="flex justify-end gap-2" x-data="{ open: false, rejection: '' }">
                                                    <!-- Approve Form -->
                                                    <form action="{{ route('admin.verification.update', $request->id) }}" method="POST" class="inline">
                                                        @csrf @method('PATCH')
                                                        <input type="hidden" name="status" value="approved">
                                                        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white p-2 rounded-lg shadow-md transition-all active:scale-95" title="Approve">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                        </button>
                                                    </form>

                                                    <!-- Reject Button -->
                                                    <button @click="open = true" class="bg-white border border-red-200 text-red-500 hover:bg-red-50 p-2 rounded-lg transition-all active:scale-95" title="Reject">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                    </button>

                                                    <!-- Rejection Modal (Alpine) -->
                                                    <template x-if="open">
                                                        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm">
                                                            <div class="bg-white rounded-3xl p-8 max-w-md w-full shadow-2xl animate-scale-in">
                                                                <h4 class="text-xl font-black text-gray-900 mb-2">Rejection Reason</h4>
                                                                <p class="text-sm text-gray-500 mb-6 uppercase tracking-widest font-bold">Explain why the application was declined</p>
                                                                <form action="{{ route('admin.verification.update', $request->id) }}" method="POST">
                                                                    @csrf @method('PATCH')
                                                                    <input type="hidden" name="status" value="rejected">
                                                                    <textarea name="rejection_reason" required class="w-full border-gray-100 rounded-2xl focus:ring-red-500 focus:border-red-500 mb-6 text-sm py-4 px-4 bg-gray-50" placeholder="e.g. Document is blurry or expired..."></textarea>
                                                                    <div class="flex justify-end gap-4">
                                                                        <button type="button" @click="open = false" class="text-xs font-black text-gray-400 uppercase tracking-widest">Cancel</button>
                                                                        <button type="submit" class="bg-red-500 text-white px-6 py-3 rounded-xl text-xs font-black uppercase tracking-widest shadow-xl hover:bg-red-600 active:scale-95 transition-all">Reject Application</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </template>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-8">
                            {{ $requests->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
