<div {{ $attributes->merge() }} class="fixed inset-0 bg-black/10 z-40">
    <div class="absolute bg-black/20 rounded-md min-w-2xl transform -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2 z-50 p-2 flex items-center justify-center">
        <div class="bg-white w-full border border-slate-300 rounded p-2">
            {{ $slot }}
        </div>
    </div>
</div>
