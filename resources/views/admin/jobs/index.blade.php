<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Admin: Job Board Management') }}
            </h2>
            <div class="flex items-center gap-2">
                <span class="px-3 py-1 bg-teal-100 text-teal-800 rounded-full text-xs font-bold">{{ $jobs->total() }} Total Jobs</span>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-100 dark:border-gray-700">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Job Title</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Posted By</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Category</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Budget</th>
                                    <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($jobs as $job)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                        <td class="px-6 py-4">
                                            <div class="text-sm font-bold text-gray-900 dark:text-gray-100">{{ $job->title }}</div>
                                            <div class="text-xs text-gray-400">{{ $job->created_at->format('M d, Y') }}</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm text-gray-900 dark:text-gray-200">{{ $job->user->name }}</div>
                                            <div class="text-xs text-gray-500">{{ $job->user->email }}</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-50 text-blue-800">
                                                {{ $job->service->name }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm font-medium text-teal-600">
                                            TZS {{ number_format($job->budget) }}
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-black uppercase rounded-full tracking-widest
                                                {{ $job->status === 'open' ? 'bg-green-100 text-green-800' : '' }}
                                                {{ $job->status === 'assigned' ? 'bg-blue-100 text-blue-800' : '' }}
                                                {{ $job->status === 'completed' ? 'bg-gray-100 text-gray-800' : '' }}
                                                {{ $job->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                                                {{ $job->status }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-right text-sm font-medium">
                                            <div class="flex items-center justify-end gap-2">
                                                <a href="{{ route('admin.jobs.show', $job->id) }}" class="text-indigo-600 hover:text-indigo-900 font-bold">Details</a>
                                                <form action="{{ route('admin.jobs.destroy', $job->id) }}" method="POST" onsubmit="return confirm('Delete this job permanently?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-500 hover:text-red-700 font-bold ml-2">Delete</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                            No jobs posted in the marketplace yet.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $jobs->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
