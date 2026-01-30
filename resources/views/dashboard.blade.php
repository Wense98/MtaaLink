<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Welcome Card -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-bold">Welcome back, {{ Auth::user()->name }}!</h3>
                    <p class="text-gray-600 dark:text-gray-400">You are logged in as a <span class="uppercase font-semibold tracking-wider text-teal-600">{{ Auth::user()->role }}</span>.</p>
                </div>
            </div>

                <!-- Profile Completeness & Performance -->
                @php
                    $profile = Auth::user()->workerProfile;
                    $score = 0;
                    if (Auth::user()->avatar) $score += 20;
                    if ($profile->bio) $score += 20;
                    if ($profile->region && $profile->district && $profile->ward) $score += 20;
                    if ($profile->portfolioImages->count() > 0) $score += 20;
                    if ($profile->price > 0) $score += 10;
                    if ($profile->experience_years > 0) $score += 10;
                    
                    $isIncomplete = $score < 100;
                @endphp

                <div class="bg-white dark:bg-gray-800 rounded-3xl p-6 shadow-sm border border-gray-100 dark:border-gray-700 mb-6">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h4 class="text-sm font-black text-gray-400 uppercase tracking-widest leading-none mb-1">Profile Strength</h4>
                            <p class="text-xs text-gray-500">Complete your profile to rank higher in search results.</p>
                        </div>
                        <span class="text-2xl font-black text-teal-600">{{ $score }}%</span>
                    </div>
                    <div class="w-full h-3 bg-gray-100 dark:bg-gray-700 rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-teal-500 to-blue-600 transition-all duration-1000 shadow-[0_0_10px_rgba(20,184,166,0.3)]" style="width: {{ $score }}%"></div>
                    </div>
                    
                    @if($isIncomplete)
                        <div class="mt-4 flex flex-wrap gap-2">
                             @if(!Auth::user()->avatar) <span class="px-2 py-1 bg-amber-50 text-amber-600 text-[10px] font-bold rounded-lg border border-amber-100">+ Add Photo</span> @endif
                             @if(!$profile->bio) <span class="px-2 py-1 bg-amber-50 text-amber-600 text-[10px] font-bold rounded-lg border border-amber-100">+ Write Bio</span> @endif
                             @if($profile->portfolioImages->count() == 0) <span class="px-2 py-1 bg-amber-50 text-amber-600 text-[10px] font-bold rounded-lg border border-amber-100">+ Add Portfolio</span> @endif
                             <a href="{{ route('worker-profile.edit') }}" class="text-[10px] font-black text-teal-600 underline ml-auto">Finish Now &rarr;</a>
                        </div>
                    @endif
                </div>

                @if($isIncomplete && $score < 60)
                    <div class="bg-amber-50 border-l-4 border-amber-400 p-4 rounded-xl shadow-sm mb-6 animate-pulse">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-amber-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.433-.798 1.57-.798 2.003 0l6.305 11.625C17.033 15.523 16.51 16.5 15.581 16.5H2.919c-.928 0-1.451-.977-1.01-1.876L8.257 3.099zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-amber-700 font-bold">
                                    Profile Yako Haijakamilika!
                                    <span class="font-medium block md:inline mt-1 md:mt-0 text-amber-600">
                                        Wateja wanaamini zaidi wahudumu wenye taarifa kamili. Tafadhali kamilisha profile yako sasa.
                                    </span>
                                </p>
                            </div>
                            <div class="ml-auto pl-3">
                                <a href="{{ route('worker-profile.edit') }}" class="text-sm bg-amber-600 text-white px-3 py-1.5 rounded-lg font-bold hover:bg-amber-700 transition shadow-sm">
                                    Kamilisha Sasa
                                </a>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- WORKER DASHBOARD -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Profile Stats -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 border border-gray-100">
                        <div class="flex justify-between items-center mb-6">
                            <h4 class="font-bold text-lg text-gray-900 dark:text-gray-100 italic">Work Stats</h4>
                            <div class="flex items-center gap-2">
                                @if(Auth::user()->is_verified)
                                    <span class="bg-green-50 text-green-700 text-[10px] font-black uppercase tracking-widest px-2.5 py-1 rounded-full border border-green-100 flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                        Verified
                                    </span>
                                @else
                                    <a href="{{ route('verification.create') }}" class="bg-yellow-50 text-yellow-700 text-[10px] font-black uppercase tracking-widest px-2.5 py-1 rounded-full border border-yellow-100 hover:bg-yellow-100 transition-colors">
                                        Get Verified
                                    </a>
                                @endif
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4 mb-6">
                             <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-2xl text-center border border-gray-100 transition-transform hover:scale-105">
                                 <span class="block text-3xl font-black text-teal-600">{{ number_format(Auth::user()->workerProfile->views_count) }}</span>
                                 <span class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Profile Views</span>
                             </div>
                             <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-2xl text-center border border-gray-100 transition-transform hover:scale-105">
                                 <span class="block text-3xl font-black text-blue-600">{{ Auth::user()->receivedRequests->count() }}</span>
                                 <span class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Total Jobs</span>
                             </div>
                        </div>

                        <div class="space-y-3">
                            <a href="{{ route('worker.show', Auth::id()) }}" target="_blank" class="block w-full text-center px-4 py-3 bg-gray-900 text-white rounded-xl text-xs font-bold uppercase tracking-widest hover:bg-black transition-all shadow-lg active:scale-95">
                                View Public Profile
                            </a>
                            <a href="{{ route('worker-profile.edit') }}" class="block w-full text-center px-4 py-3 bg-white text-gray-700 border border-gray-200 rounded-xl text-xs font-bold uppercase tracking-widest hover:bg-gray-50 transition-all">
                                Update My Portfolio
                            </a>
                        </div>
                    </div>

                    <!-- Activity Trends Chart -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 border border-gray-100">
                         <h4 class="font-bold text-lg text-gray-900 dark:text-gray-100 italic mb-4">Service Interest (Last 7 Days)</h4>
                         <div class="h-48">
                            <canvas id="requestsChart"></canvas>
                         </div>
                         
                         @php
                            $labels = [];
                            $data = [];
                            for($i = 6; $i >= 0; $i--) {
                                $date = now()->subDays($i)->format('Y-m-d');
                                $labels[] = now()->subDays($i)->format('D');
                                $data[] = Auth::user()->receivedRequests()->whereDate('created_at', $date)->count();
                            }
                         @endphp
                         
                         <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                const ctx = document.getElementById('requestsChart').getContext('2d');
                                new Chart(ctx, {
                                    type: 'line',
                                    data: {
                                        labels: {!! json_encode($labels) !!},
                                        datasets: [{
                                            label: 'Requests',
                                            data: {!! json_encode($data) !!},
                                            borderColor: '#0d9488',
                                            backgroundColor: 'rgba(13, 148, 136, 0.1)',
                                            fill: true,
                                            tension: 0.4,
                                            borderWidth: 3,
                                            pointRadius: 4,
                                            pointBackgroundColor: '#0d9488'
                                        }]
                                    },
                                    options: {
                                        responsive: true,
                                        maintainAspectRatio: false,
                                        plugins: { legend: { display: false } },
                                        scales: {
                                            y: { beginAtZero: true, grid: { display: false }, ticks: { stepSize: 1, font: { size: 10 } } },
                                            x: { grid: { display: false }, ticks: { font: { size: 10 } } }
                                        }
                                    }
                                });
                            });
                         </script>
                    </div>
                    
                    <!-- Market Intelligence -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 flex flex-col justify-between border border-gray-100">
                         <div class="flex items-center gap-2 mb-4">
                            <h4 class="font-bold text-lg text-gray-900 dark:text-gray-100 italic">Market Intelligence</h4>
                            <span class="px-2 py-0.5 rounded-full bg-indigo-50 text-indigo-600 text-[8px] font-black uppercase tracking-widest border border-indigo-100">Live</span>
                         </div>
                         
                         @php
                            $profile = Auth::user()->workerProfile;
                            $competitorsInWard = \App\Models\WorkerProfile::where('service_id', $profile->service_id)
                                ->where('ward', $profile->ward)
                                ->where('user_id', '!=', Auth::id())
                                ->count();
                            $avgPriceInDistrict = \App\Models\WorkerProfile::where('service_id', $profile->service_id)
                                ->where('district', $profile->district)
                                ->avg('price');
                         @endphp

                         <div class="space-y-4">
                             <div class="flex items-center justify-between">
                                 <span class="text-xs text-gray-500 font-medium italic">Peers in {{ $profile->ward ?: 'Your Ward' }}</span>
                                 <span class="text-sm font-black text-gray-900">{{ $competitorsInWard }} Pros</span>
                             </div>
                             <div class="h-1.5 w-full bg-gray-50 rounded-full overflow-hidden">
                                 <div class="h-full bg-indigo-500 rounded-full" style="width: {{ min(100, ($competitorsInWard + 1) * 20) }}%"></div>
                             </div>
                             <div class="flex items-center justify-between">
                                 <span class="text-xs text-gray-500 font-medium italic">Avg Price in {{ $profile->district ?: 'District' }}</span>
                                 <span class="text-sm font-black text-teal-600">TZS {{ number_format($avgPriceInDistrict ?: 0) }}</span>
                             </div>
                             @if($profile->price < $avgPriceInDistrict)
                                <p class="text-[10px] text-green-600 font-bold bg-green-50 p-2 rounded-lg border border-green-100">
                                    Your price is below average. High potential for direct bookings!
                                </p>
                             @elseif($profile->price > $avgPriceInDistrict)
                                <p class="text-[10px] text-amber-600 font-bold bg-amber-50 p-2 rounded-lg border border-amber-100">
                                    Your price is above average. Make sure your portfolio shines!
                                </p>
                             @endif
                         </div>
                    </div>

                    <!-- Availability Status -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 border border-gray-100">
                         <h4 class="font-bold text-lg text-gray-900 dark:text-gray-100 italic mb-4">Availability Status</h4>
                         <div class="flex items-center justify-between p-4 bg-gray-50 rounded-2xl border border-gray-100">
                            <span class="text-xs font-bold text-gray-600 dark:text-gray-400">
                                @if(Auth::user()->workerProfile->is_available)
                                    <span class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span> Receiving Requests</span>
                                @else
                                    <span class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-gray-400"></span> Appear Unavailable</span>
                                @endif
                            </span>
                            
                            <form action="{{ route('worker-profile.availability') }}" method="POST">
                                @csrf
                                <button type="submit" class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none {{ Auth::user()->workerProfile->is_available ? 'bg-teal-600' : 'bg-gray-200' }}">
                                    <span aria-hidden="true" class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out {{ Auth::user()->workerProfile->is_available ? 'translate-x-5' : 'translate-x-0' }}"></span>
                                </button>
                            </form>
                         </div>
                         <p class="text-[10px] text-gray-400 font-medium mt-3 italic">Turning this off will hide your profile from most search results temporarily.</p>
                    </div>

                    <!-- Incoming Requests -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 md:col-span-2">
                        <div class="flex justify-between items-center mb-4">
                            <h4 class="font-semibold text-lg text-gray-800 dark:text-gray-200">Incoming Job Requests</h4>
                            <span class="text-xs font-bold text-gray-400 capitalize">Real-time Feed</span>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Customer</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Message</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Details</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @forelse(Auth::user()->receivedRequests()->latest()->get() as $request)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">{{ $request->user->name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $request->requested_date ? $request->requested_date->format('M d, Y') : 'ASAP' }}</td>
                                            <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400 max-w-xs truncate">{{ $request->message }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                @if($request->image_path)
                                                    <a href="{{ asset('storage/' . $request->image_path) }}" target="_blank" class="text-teal-600 hover:text-teal-900 font-bold flex items-center gap-1">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h14a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                        View Photo
                                                    </a>
                                                @else
                                                    <span class="text-gray-300 italic">No attachment</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                    {{ $request->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                    {{ $request->status === 'accepted' ? 'bg-green-100 text-green-800' : '' }}
                                                    {{ $request->status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}
                                                    {{ $request->status === 'completed' ? 'bg-gray-100 text-gray-800' : '' }}">
                                                    {{ ucfirst($request->status) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium" x-data="{ quoting: false }">
                                                @if($request->status === 'pending')
                                                    <div x-show="!quoting" class="flex items-center gap-2">
                                                        <button @click="quoting = true" class="text-teal-600 hover:text-teal-900 font-bold">Accept & Quote</button>
                                                        <span class="text-gray-300">|</span>
                                                        <form action="{{ route('requests.update-status', $request->id) }}" method="POST" class="inline">
                                                            @csrf @method('PATCH')
                                                            <input type="hidden" name="status" value="rejected">
                                                            <button type="submit" class="text-red-500 hover:text-red-700 font-bold">Reject</button>
                                                        </form>
                                                    </div>

                                                    <!-- Quote Form (Inline) -->
                                                    <div x-show="quoting" x-cloak class="bg-gray-50 p-3 rounded-xl border border-teal-100 animate-fade-in">
                                                        <form action="{{ route('requests.update-status', $request->id) }}" method="POST">
                                                            @csrf @method('PATCH')
                                                            <input type="hidden" name="status" value="accepted">
                                                            <div class="space-y-2">
                                                                <input type="number" name="price_estimate" placeholder="Price (TZS)" class="w-full text-xs rounded-lg border-gray-200 py-1.5 focus:ring-teal-500" required>
                                                                <textarea name="worker_notes" placeholder="Notes (optional)" class="w-full text-[10px] rounded-lg border-gray-200 py-1.5 focus:ring-teal-500" rows="2"></textarea>
                                                                <div class="flex justify-end gap-2">
                                                                    <button type="button" @click="quoting = false" class="text-[10px] font-bold text-gray-400">Cancel</button>
                                                                    <button type="submit" class="text-[10px] font-black uppercase tracking-widest bg-teal-600 text-white px-3 py-1 rounded-lg">Send Quote</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                @elseif($request->status === 'accepted')
                                                     <div class="flex items-center gap-3">
                                                        <form action="{{ route('requests.update-status', $request->id) }}" method="POST" class="inline">
                                                            @csrf @method('PATCH')
                                                            <input type="hidden" name="status" value="completed">
                                                            <button type="submit" class="text-teal-600 hover:text-teal-900 font-bold">Complete Job</button>
                                                        </form>
                                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $request->user->phone) }}" target="_blank" class="text-green-500 hover:scale-110 transition-transform">
                                                            <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                                                        </a>
                                                     </div>
                                                @else
                                                    <span class="text-gray-400">Closed</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="px-6 py-4 text-center text-gray-500 italic">No job requests yet.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- My Ratings / Reviews -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 md:col-span-2">
                        <div class="flex justify-between items-center mb-6">
                            <h4 class="font-semibold text-lg text-gray-800 dark:text-gray-200">My Reputation</h4>
                            <div class="flex items-center gap-1 bg-yellow-50 px-3 py-1 rounded-full">
                                <span class="text-sm font-black text-yellow-700">{{ number_format(Auth::user()->receivedReviews()->avg('rating') ?? 5, 1) }}</span>
                                <svg class="w-4 h-4 text-yellow-500 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @forelse(Auth::user()->receivedReviews()->latest()->take(4)->get() as $review)
                                <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl border border-gray-100 dark:border-gray-600">
                                    <div class="flex justify-between items-start mb-2">
                                        <span class="text-xs font-bold text-gray-900 dark:text-gray-100">{{ $review->user->name }}</span>
                                        <div class="flex">
                                            @for($i=1; $i<=5; $i++)
                                                <svg class="w-2.5 h-2.5 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-200' }} fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                            @endfor
                                        </div>
                                    </div>
                                    <p class="text-xs text-gray-500 italic">"{{ $review->comment }}"</p>
                                    <span class="block text-[10px] text-gray-400 mt-2">{{ $review->created_at->diffForHumans() }}</span>
                                </div>
                            @empty
                                <div class="col-span-2 text-center py-6 text-gray-400 italic text-sm">No reviews yet. Deliver great service to get your first one!</div>
                            @endforelse
                        </div>
                    </div>
                </div>

                </div>

            @elseif(Auth::user()->role === 'admin')
                <!-- ADMIN DASHBOARD -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Stats Cards (Stacked on Left) -->
                    <div class="lg:col-span-1 space-y-6">
                        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl p-6 border-l-4 border-teal-500">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-teal-100 text-teal-600 mr-4">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Total Workers</p>
                                    <p class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ \App\Models\User::where('role', 'worker')->count() }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl p-6 border-l-4 border-blue-500">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Total Customers</p>
                                    <p class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ \App\Models\User::where('role', 'customer')->count() }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Actions -->
                        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl p-6 border border-gray-100 space-y-3">
                             <h4 class="font-bold text-gray-900 dark:text-gray-100 mb-2">Management</h4>
                             <a href="{{ route('admin.services.index') }}" class="block w-full text-center px-4 py-2 bg-gray-100 text-gray-800 rounded-lg hover:bg-gray-200 transition-colors font-medium text-sm">
                                 Manage Services
                             </a>
                             <a href="{{ route('admin.workers.index') }}" class="block w-full text-center px-4 py-2 bg-teal-50 text-teal-700 rounded-lg hover:bg-teal-100 transition-colors font-medium text-sm">
                                 Manage Workers
                             </a>
                             <a href="{{ route('admin.verification.index') }}" class="block w-full text-center px-4 py-2 bg-yellow-50 text-yellow-700 rounded-lg hover:bg-yellow-100 transition-colors font-medium text-sm">
                                 Verification Requests
                             </a>
                        </div>
                    </div>

                    <!-- Main Content (Right) -->
                    <div class="lg:col-span-2 space-y-6">
                        <!-- Recent Activity / All Requests -->
                        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl p-6 border border-gray-100">
                             <div class="flex justify-between items-center mb-4">
                                 <h4 class="font-bold text-lg text-gray-900 dark:text-gray-100">Recent Service Activity</h4>
                                 <span class="text-xs font-bold text-gray-400 capitalize">System Audit</span>
                             </div>
                             <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-100">
                                    <thead>
                                        <tr class="text-left text-xs font-bold text-gray-400 uppercase tracking-widest">
                                            <th class="pb-3">Customer</th>
                                            <th class="pb-3">Worker</th>
                                            <th class="pb-3 text-right">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-50">
                                        @forelse(\App\Models\Request::with(['user', 'worker'])->latest()->take(6)->get() as $activity)
                                            <tr>
                                                <td class="py-4">
                                                    <div class="text-sm font-bold text-gray-900">{{ $activity->user->name }}</div>
                                                    <div class="text-[10px] text-gray-400">{{ $activity->created_at->diffForHumans() }}</div>
                                                </td>
                                                <td class="py-4">
                                                    <div class="text-sm font-medium text-gray-600">{{ $activity->worker->name }}</div>
                                                </td>
                                                <td class="py-4 text-right">
                                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-black uppercase
                                                        {{ $activity->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                                        {{ $activity->status === 'accepted' ? 'bg-green-100 text-green-700' : '' }}
                                                        {{ $activity->status === 'rejected' ? 'bg-red-100 text-red-700' : '' }}
                                                        {{ $activity->status === 'completed' ? 'bg-blue-100 text-blue-700' : '' }}">
                                                        {{ $activity->status }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr><td colspan="3" class="py-8 text-center text-gray-400 italic">No system activity yet.</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                             </div>
                        </div>

                        <!-- Pending Verifications (Repositioned) -->
                        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl p-6 border border-gray-100">
                            <div class="flex justify-between items-center mb-4">
                                 <h4 class="font-bold text-lg text-gray-900 dark:text-gray-100">Pending Verifications</h4>
                                 <a href="{{ route('admin.workers.index') }}" class="text-xs text-teal-600 hover:text-teal-800 font-bold uppercase tracking-wide">View All &rarr;</a>
                            </div>
                            <div class="overflow-x-auto">
                                <table class="min-w-full">
                                    <tbody class="divide-y divide-gray-100">
                                        @forelse(\App\Models\User::where('role', 'worker')->where('is_verified', false)->latest()->take(4)->get() as $pendingWorker)
                                            <tr>
                                                <td class="py-3">
                                                    <div class="text-sm font-bold text-gray-900">{{ $pendingWorker->name }}</div>
                                                    <div class="text-xs text-gray-500">{{ $pendingWorker->workerProfile->service->name ?? 'Service N/A' }}</div>
                                                </td>
                                                <td class="py-3 text-right">
                                                    <a href="{{ route('admin.workers.show', $pendingWorker->id) }}" class="inline-flex items-center px-3 py-1 bg-gray-900 text-white rounded-lg text-[10px] font-bold hover:bg-teal-600 transition-colors">
                                                        Review
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="2" class="py-4 text-center text-sm text-gray-400">All workers are verified.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            @else
                <!-- CUSTOMER DASHBOARD -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Search Card -->
                    <div class="bg-gradient-to-br from-teal-500 to-teal-600 text-white shadow-xl rounded-xl p-6 transform hover:scale-105 transition-transform duration-300">
                        <svg class="w-10 h-10 mb-4 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        <h4 class="font-bold text-xl mb-2">Find Help</h4>
                        <p class="text-teal-100 text-sm mb-4">Search for social workers in your Mtaa.</p>
                        <a href="{{ route('search.index') }}" class="inline-block px-4 py-2 bg-white text-teal-600 font-bold rounded-lg shadow-sm hover:shadow-md transition-shadow">Start Searching</a>
                    </div>

                    <!-- My Requests List -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl p-6 border border-gray-100 md:col-span-2">
                         <h4 class="font-bold text-gray-900 dark:text-gray-100 text-lg mb-4">My Sent Requests</h4>
                         <div class="space-y-4">
                            @forelse(Auth::user()->sentRequests()->with('worker')->latest()->get() as $req)
                                <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between mb-2">
                                            <p class="font-bold text-gray-900 dark:text-gray-100">Request to {{ $req->worker->name }}</p>
                                            <span class="px-2 py-0.5 text-[10px] font-black uppercase rounded-full tracking-widest
                                                {{ $req->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                {{ $req->status === 'accepted' ? 'bg-green-100 text-green-800' : '' }}
                                                {{ $req->status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}
                                                {{ $req->status === 'completed' ? 'bg-blue-100 text-blue-800' : '' }}">
                                                {{ $req->status }}
                                            </span>
                                        </div>
                                        <p class="text-sm text-gray-500 line-clamp-1 mb-2">{{ $req->message }}</p>
                                        
                                        @if($req->price_estimate)
                                            <div class="bg-teal-50 border border-teal-100 p-3 rounded-xl mb-3 animate-fade-in-up">
                                                <div class="flex items-center justify-between mb-1">
                                                    <span class="text-[10px] font-black text-teal-600 uppercase tracking-widest">Price Quote</span>
                                                    <span class="text-sm font-black text-gray-900">TZS {{ number_format($req->price_estimate) }}</span>
                                                </div>
                                                @if($req->worker_notes)
                                                    <p class="text-[10px] text-teal-700 italic">"{{ $req->worker_notes }}"</p>
                                                @endif
                                                
                                                @if(session('status') === 'quote-accepted' && session('request_id') == $req->id)
                                                    <div class="mt-2 text-[10px] font-bold text-green-600 flex items-center gap-1">
                                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                                        Quote Accepted
                                                    </div>
                                                @else
                                                    <form action="{{ route('requests.accept-quote', $req->id) }}" method="POST" class="mt-2">
                                                        @csrf
                                                        <button type="submit" class="w-full py-1.5 bg-gray-900 text-white text-[10px] font-black uppercase rounded-lg hover:bg-teal-600 transition-colors shadow-sm">
                                                            Accept Quote
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        @endif

                                        <p class="text-[10px] text-gray-400 font-medium italic">Sent {{ $req->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-8 text-gray-500">
                                    You haven't sent any requests yet.
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Saved Workers List -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl p-6 border border-gray-100 md:col-span-3">
                         <h4 class="font-bold text-gray-900 dark:text-gray-100 text-lg mb-4 flex items-center">
                            <svg class="w-5 h-5 text-red-500 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path></svg>
                            Saved Professionals
                         </h4>
                         
                         @if(Auth::user()->favorites->count() > 0)
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                                @foreach(Auth::user()->favorites as $profile)
                                    <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 hover:shadow-md transition-shadow flex items-start space-x-4">
                                        <div class="flex-shrink-0">
                                            @if($profile->user->avatar)
                                                <img src="{{ asset('storage/' . $profile->user->avatar) }}" class="w-12 h-12 rounded-full object-cover">
                                            @else
                                                <div class="w-12 h-12 rounded-full bg-teal-100 flex items-center justify-center text-teal-600 font-bold">
                                                    {{ substr($profile->user->name, 0, 1) }}
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-900 dark:text-gray-100 truncate">
                                                {{ $profile->user->name }}
                                            </p>
                                            <p class="text-xs text-teal-600 truncate">{{ $profile->service->name }}</p>
                                            <p class="text-xs text-gray-500 truncate">{{ $profile->region }}</p>
                                            <div class="mt-2">
                                                <a href="{{ route('worker.show', $profile->user->id) }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800">View Profile &rarr;</a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                         @else
                            <p class="text-gray-500 text-sm italic">You haven't saved any workers yet.</p>
                         @endif
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
