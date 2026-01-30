<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Account Verification') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Progress Steps (Visual) -->
            <div class="mb-10">
                <div class="flex items-center justify-between relative">
                    <div class="absolute inset-0 flex items-center" aria-hidden="true">
                        <div class="w-full border-t border-gray-200 dark:border-gray-700"></div>
                    </div>
                    <div class="relative flex items-center justify-center w-10 h-10 rounded-full bg-teal-600 text-white font-bold ring-4 ring-white shadow-md">1</div>
                    <div class="relative flex items-center justify-center w-10 h-10 rounded-full {{ $existingRequest ? 'bg-teal-600 text-white' : 'bg-white text-gray-400 border border-gray-200' }} font-bold ring-4 ring-white shadow-sm">2</div>
                    <div class="relative flex items-center justify-center w-10 h-10 rounded-full bg-white text-gray-400 border border-gray-200 font-bold ring-4 ring-white shadow-sm">3</div>
                </div>
                <div class="flex justify-between mt-4 text-xs font-bold uppercase tracking-widest text-gray-500">
                    <span>Submit Documents</span>
                    <span>Admin Review</span>
                    <span>Verified Badge</span>
                </div>
            </div>

            @if($existingRequest && $existingRequest->status === 'pending')
                <div class="bg-blue-50 border-l-4 border-blue-400 p-6 rounded-xl shadow-sm mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-bold text-blue-700">
                                You have a pending verification request.
                            </p>
                            <p class="text-xs text-blue-600 mt-1">
                                Submitted on {{ $existingRequest->created_at->format('M d, Y') }}. Our team is currently reviewing your documents.
                            </p>
                        </div>
                    </div>
                </div>
            @elseif($existingRequest && $existingRequest->status === 'rejected')
                <div class="bg-red-50 border-l-4 border-red-400 p-6 rounded-xl shadow-sm mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                             <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-bold text-red-700 uppercase tracking-wide">Request Rejected</p>
                            <p class="text-xs text-red-600 mt-1">Reason: {{ $existingRequest->rejection_reason }}</p>
                            <p class="text-xs text-red-600 mt-2 font-semibold italic">Please re-submit clear documents to proceed.</p>
                        </div>
                    </div>
                </div>
            @endif

            @if(!$existingRequest || $existingRequest->status === 'rejected')
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-2xl rounded-3xl border border-gray-100 dark:border-gray-700">
                <div class="p-8 lg:p-12">
                    <div class="mb-8">
                        <h3 class="text-2xl font-black text-gray-900 dark:text-white mb-2">Build Community Trust</h3>
                        <p class="text-gray-500 dark:text-gray-400 text-sm">Verified workers receive <span class="text-teal-600 font-bold">3x more job requests</span> on average. Your information is stored securely and only used for verification.</p>
                    </div>

                    <form action="{{ route('verification.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        
                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="id_type" :value="__('Identification Type')" class="font-bold text-xs uppercase text-gray-400 tracking-widest mb-1" />
                                <select id="id_type" name="id_type" class="w-full border-gray-100 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-teal-500 focus:ring-teal-500 rounded-xl shadow-sm py-3 transition-all" required>
                                    <option value="">Select ID Type</option>
                                    <option value="NIDA">NIDA (National ID)</option>
                                    <option value="Passport">Passport</option>
                                    <option value="Voter ID">Voter ID Card</option>
                                    <option value="Driving License">Driving License</option>
                                </select>
                                <x-input-error :messages="$errors->get('id_type')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="id_number" :value="__('ID Number')" class="font-bold text-xs uppercase text-gray-400 tracking-widest mb-1" />
                                <x-text-input id="id_number" name="id_number" type="text" class="w-full py-3 px-4 rounded-xl border-gray-100 shadow-sm focus:ring-teal-500 focus:border-teal-500" placeholder="Enter ID number" required />
                                <x-input-error :messages="$errors->get('id_number')" class="mt-2" />
                            </div>
                        </div>

                        <div class="mt-4">
                            <x-input-label for="document" :value="__('Upload Document Photo')" class="font-bold text-xs uppercase text-gray-400 tracking-widest mb-1" />
                            <div class="mt-1 flex justify-center px-6 pt-10 pb-10 border-2 border-gray-100 border-dashed rounded-3xl hover:border-teal-400 transition-colors group cursor-pointer relative bg-gray-50">
                                <div class="space-y-2 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400 group-hover:text-teal-500 transition-colors" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600">
                                        <label for="document" class="relative cursor-pointer rounded-md font-bold text-teal-600 hover:text-teal-500 focus-within:outline-none">
                                            <span>Upload a file</span>
                                            <input id="document" name="document" type="file" class="sr-only" required onchange="updateFileName(this)">
                                        </label>
                                        <p class="pl-1">or drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-400 uppercase font-bold tracking-widest">PNG, JPG, PDF up to 5MB</p>
                                    <p id="file-name-display" class="text-sm font-bold text-teal-600 mt-2 hidden"></p>
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('document')" class="mt-2" />
                        </div>

                        <div class="flex items-start gap-3 bg-gray-50 p-4 rounded-2xl border border-gray-100">
                             <input type="checkbox" required class="mt-1 rounded border-gray-300 text-teal-600 shadow-sm focus:ring-teal-500">
                             <p class="text-xs text-gray-500 leading-relaxed">
                                 I confirm that the information provided is accurate and the document uploaded is my own. I understand that misrepresentation will lead to permanent account suspension.
                             </p>
                        </div>

                        <div class="flex items-center justify-end gap-4 pt-4">
                            <a href="{{ route('dashboard') }}" class="text-sm font-bold text-gray-500 hover:text-gray-700 transition-colors uppercase tracking-widest">Cancel</a>
                            <x-primary-button class="bg-gray-900 px-8 py-3 rounded-xl hover:bg-teal-600 shadow-xl transition-all">
                                {{ __('Submit Application') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
            @endif

            <div class="mt-8 text-center text-gray-400 text-xs font-medium uppercase tracking-widest flex items-center justify-center gap-2">
                 <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                 Encrypted End-to-End
            </div>
        </div>
    </div>

    <script>
        function updateFileName(input) {
            const display = document.getElementById('file-name-display');
            if (input.files && input.files[0]) {
                display.textContent = 'Selected: ' + input.files[0].name;
                display.classList.remove('hidden');
            }
        }
    </script>
</x-app-layout>
