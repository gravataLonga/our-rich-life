<div {{ $attributes->merge() }} class="flex space-x-2">
    <x-heroicon-s-home class="w-6 h-6"/>
    <x-heroicon-o-chevron-right class="w-6 h-6"/>
    {{ $slot }}
</div>
