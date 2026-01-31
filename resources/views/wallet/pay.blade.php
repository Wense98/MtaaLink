<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Secure Payment Checkout') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-xl rounded-3xl p-8 border border-gray-100 dark:border-gray-700">
                <div class="text-center mb-8">
                    <div class="w-16 h-16 bg-teal-100 text-teal-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    </div>
                    <h3 class="text-2xl font-black text-gray-900 dark:text-gray-100">Secure Escrow Payment</h3>
                    <p class="text-sm text-gray-500 mt-2">Your funds will be held securely until the work is completed.</p>
                </div>

                <div class="bg-gray-50 dark:bg-gray-700/50 rounded-2xl p-6 mb-8">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm text-gray-500">Service</span>
                        <span class="font-bold text-gray-900 dark:text-gray-100 text-right">{{ Str::limit($request->message, 30) }}</span>
                    </div>
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm text-gray-500">Provider</span>
                        <span class="font-bold text-gray-900 dark:text-gray-100">{{ $request->worker->name }}</span>
                    </div>
                    <div class="border-t border-gray-200 dark:border-gray-600 my-4"></div>
                    <div class="flex justify-between items-center">
                        <span class="text-lg font-bold text-gray-900 dark:text-gray-100">Total Amount</span>
                        <span class="text-2xl font-black text-teal-600">TZS {{ number_format($request->price_estimate) }}</span>
                    </div>
                </div>

                <form action="{{ route('wallet.process', $request->id) }}" method="POST">
                    @csrf
                    
                    <div class="mb-6">
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-widest mb-2">Select Mobile Network</label>
                        <div class="grid grid-cols-2 gap-4">
                            <label class="cursor-pointer">
                                <input type="radio" name="payment_method" value="MPESA" class="peer sr-only" required>
                                <div class="p-4 rounded-xl border-2 border-gray-200 hover:border-red-500 peer-checked:border-red-600 peer-checked:bg-red-50 transition-all text-center">
                                    <span class="font-bold text-gray-800">M-PESA</span>
                                </div>
                            </label>
                            <label class="cursor-pointer">
                                <input type="radio" name="payment_method" value="TIGOPESA" class="peer sr-only">
                                <div class="p-4 rounded-xl border-2 border-gray-200 hover:border-blue-500 peer-checked:border-blue-600 peer-checked:bg-blue-50 transition-all text-center">
                                    <span class="font-bold text-gray-800">Tigo Pesa</span>
                                </div>
                            </label>
                            <label class="cursor-pointer">
                                <input type="radio" name="payment_method" value="AIRTEL" class="peer sr-only">
                                <div class="p-4 rounded-xl border-2 border-gray-200 hover:border-red-500 peer-checked:border-red-600 peer-checked:bg-red-50 transition-all text-center">
                                    <span class="font-bold text-gray-800">Airtel Money</span>
                                </div>
                            </label>
                            <label class="cursor-pointer">
                                <input type="radio" name="payment_method" value="HALOPESA" class="peer sr-only">
                                <div class="p-4 rounded-xl border-2 border-gray-200 hover:border-orange-500 peer-checked:border-orange-600 peer-checked:bg-orange-50 transition-all text-center">
                                    <span class="font-bold text-gray-800">HaloPesa</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div class="mb-8">
                        <label class="block text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-widest mb-2">Mobile Number</label>
                        <input type="text" name="phone" placeholder="07XXXXXXXX" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 py-3" required>
                    </div>

                    <button type="submit" class="w-full py-4 bg-gray-900 text-white font-bold rounded-xl shadow-lg hover:bg-black transition-all flex justify-center items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        Confirm Payment
                    </button>
                    <p class="text-xs text-center text-gray-400 mt-4">Simulated Payment Environment</p>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
