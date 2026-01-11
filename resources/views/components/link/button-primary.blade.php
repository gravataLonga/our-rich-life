<a
    {{ $attributes->merge() }}
    class="bg-gray-800 hover:bg-gray-500 text-white text-sm font-semibold py-1.5 px-3 rounded-md transition-colors duration-200 flex items-center justify-center gap-2"
    href="{{ $href ?? '' }}">
    {{ $slot }}
</a>
