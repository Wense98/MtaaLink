@props(['type' => 'info', 'message' => ''])
<div role="status" aria-live="polite" class="fixed top-6 right-6 z-50">
  <div class="max-w-sm w-full">
    <div class="p-4 rounded-lg shadow-sm border border-slate-100 bg-white text-sm text-slate-800">
      <div class="flex items-start gap-3">
        <div>
          @if($type === 'success')
            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
          @elseif($type === 'error')
            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
          @else
            <svg class="w-5 h-5 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 110 20 10 10 0 010-20z"/></svg>
          @endif
        </div>
        <div class="flex-1">
          <p class="leading-tight">{{ $message }}</p>
        </div>
        <div>
          <button aria-label="Dismiss" class="text-slate-400 hover:text-slate-600" onclick="this.closest('[role=\'status\']').remove()">&times;</button>
        </div>
      </div>
    </div>
  </div>
</div>
