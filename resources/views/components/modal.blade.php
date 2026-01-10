<div {{ $attributes->merge() }} class="fixed inset-0 bg-black/10 z-40 p-10" x-data="{}">
    <div class="absolute bg-black/20 rounded-md min-w-2xl transform -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2 z-50 p-2 flex items-center justify-center">
        <div @click.outside="$wire.$dispatch('modalClose')" class="bg-white w-full border border-slate-300 rounded p-2 max-h-[calc(100vh-5rem)] overflow-y-auto">
            {{ $slot }}
        </div>
    </div>
</div>
