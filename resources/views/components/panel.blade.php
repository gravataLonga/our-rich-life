<div class="rounded overflow-hidden" {{ $attributes->merge() }}>
    <div class="bg-slate-600 text-white font-semibold text-lg px-4 py-2">{{ $header }}</div>
    <div class="bg-white px-4 py-2 border border-slate-200">
        {{ $slot }}
    </div>
</div>
