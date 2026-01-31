@props(['profile'])
<div {{ $attributes->merge(['class' => 'bg-white rounded-xl shadow-sm p-4 border border-slate-100 flex items-start gap-4']) }}>
  <div class="flex-shrink-0">
    @if($profile->user->avatar)
      <img src="{{ asset('storage/' . $profile->user->avatar) }}" alt="{{ $profile->user->name }} avatar" class="w-14 h-14 rounded-full object-cover">
    @else
      <div class="w-14 h-14 rounded-full bg-primary-100 flex items-center justify-center text-primary-700 font-bold">{{ substr($profile->user->name,0,1) }}</div>
    @endif
  </div>
  <div class="flex-1 min-w-0">
    <div class="flex items-center justify-between">
      <div>
        <div class="text-sm font-bold text-slate-900">{{ $profile->user->name }}</div>
        <div class="text-xs text-slate-500">{{ $profile->service->name ?? 'Service' }}</div>
      </div>
      <div class="text-sm text-slate-600 font-semibold">TZS {{ number_format($profile->price ?: 0) }}</div>
    </div>
    <div class="mt-3 flex items-center gap-2">
      <a href="{{ route('worker.show', $profile->user->id) }}" class="text-xs text-sky-600 hover:underline">View</a>
      <a href="/requests/create?worker={{ $profile->user->id }}" class="ml-2 inline-flex items-center px-3 py-1.5 bg-emerald-600 text-white rounded text-xs">Request</a>
    </div>
  </div>
</div>
