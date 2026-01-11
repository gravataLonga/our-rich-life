<button
    {{ $attributes->merge() }}
    class="bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-semibold py-1.5 px-3 rounded-md transition-colors duration-200 flex items-center justify-center gap-2 cursor-pointer">
    {{ $slot }}
</button>
