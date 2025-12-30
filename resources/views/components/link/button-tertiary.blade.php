<a
    {{ $attributes->merge() }}
    class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-2.5 px-4 rounded-md transition-colors duration-200 flex items-center justify-center gap-2"
    href="{{ $href ?? '' }}">
    {{ $slot }}
</a>
