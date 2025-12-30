<a
    {{ $attributes->merge() }}
    class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2.5 px-4 rounded-md transition-colors duration-200 flex items-center justify-center gap-2"
    href="{{ $href ?? '' }}">
    {{ $slot }}
</a>
