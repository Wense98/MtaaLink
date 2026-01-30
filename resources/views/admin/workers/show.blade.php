<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Verify Worker: {{ $worker->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-lg font-bold">{{ $worker->name }}</h3>
                            <p class="text-sm text-gray-500">{{ $worker->email }} | {{ $worker->phone }}</p>
                            <p class="mt-2 text-gray-700 font-semibold">Service: {{ $worker->workerProfile->service->name ?? 'N/A' }}</p>
                            <p class="text-gray-700">Location: {{ $worker->workerProfile->region }}, {{ $worker->workerProfile->district }}, {{ $worker->workerProfile->ward }}</p>
                        </div>
                        <div>
                            @if($worker->is_verified)
                                <form action="{{ route('admin.workers.unverify', $worker->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded shadow hover:bg-red-700">Revoke Verification</button>
                                </form>
                            @else
                                <form action="{{ route('admin.workers.verify', $worker->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded shadow hover:bg-green-700">Approve & Verify</button>
                                </form>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Feature Toggle -->
                    <div class="mt-4 border-t pt-4 flex justify-between items-center">
                        <div>
                            <span class="text-gray-700 font-medium">Featured Status:</span>
                            @if($worker->workerProfile && $worker->workerProfile->is_featured)
                                <span class="bg-yellow-100 text-yellow-800 text-xs font-bold px-2 py-1 rounded ml-2">Featured</span>
                            @else
                                <span class="text-gray-500 text-xs ml-2">Standard</span>
                            @endif
                        </div>
                        <div>
                             @if($worker->workerProfile && $worker->workerProfile->is_featured)
                                <form action="{{ route('admin.workers.unfeature', $worker->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-sm text-red-600 hover:text-red-900 underline">Remove from Featured</button>
                                </form>
                            @else
                                <form action="{{ route('admin.workers.feature', $worker->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-sm text-indigo-600 hover:text-indigo-900 underline">Mark as Featured</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Documents Section -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h4 class="font-bold text-gray-800 mb-4">NIDA / ID Document</h4>
                        @if($worker->workerProfile && $worker->workerProfile->id_document)
                            <div class="aspect-w-16 aspect-h-9 bg-gray-100 rounded-lg overflow-hidden border border-gray-200">
                                <a href="{{ asset('storage/' . $worker->workerProfile->id_document) }}" target="_blank">
                                    <img src="{{ asset('storage/' . $worker->workerProfile->id_document) }}" alt="ID Document" class="object-cover w-full h-64">
                                </a>
                            </div>
                            <div class="mt-2 text-center">
                                <a href="{{ asset('storage/' . $worker->workerProfile->id_document) }}" target="_blank" class="text-indigo-600 hover:underline text-sm">View Full Size</a>
                            </div>
                        @else
                            <div class="bg-yellow-50 p-4 rounded text-yellow-700 text-sm">
                                No ID document uploaded.
                            </div>
                        @endif
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h4 class="font-bold text-gray-800 mb-4">Police Clearance</h4>
                        @if($worker->workerProfile && $worker->workerProfile->police_clearance)
                            <div class="aspect-w-16 aspect-h-9 bg-gray-100 rounded-lg overflow-hidden border border-gray-200">
                                <a href="{{ asset('storage/' . $worker->workerProfile->police_clearance) }}" target="_blank">
                                    <img src="{{ asset('storage/' . $worker->workerProfile->police_clearance) }}" alt="Police Clearance" class="object-cover w-full h-64">
                                </a>
                            </div>
                             <div class="mt-2 text-center">
                                <a href="{{ asset('storage/' . $worker->workerProfile->police_clearance) }}" target="_blank" class="text-indigo-600 hover:underline text-sm">View Full Size</a>
                            </div>
                        @else
                            <div class="bg-gray-50 p-4 rounded text-gray-500 text-sm">
                                No Police Clearance document uploaded.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>