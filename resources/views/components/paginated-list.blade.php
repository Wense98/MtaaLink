@props(['title' => null])
<div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
  <div class="p-4 border-b border-slate-100 flex items-center justify-between">
    <div class="font-semibold text-slate-800">{{ $title }}</div>
    <div class="text-xs text-slate-500">{{ $slot->count() ?? '' }}</div>
  </div>
  <div class="p-4">
    {{ $slot }}
  </div>
  <div class="p-4 border-t border-slate-100">
    {{ $links ?? '' }}
  </div>
</div>
