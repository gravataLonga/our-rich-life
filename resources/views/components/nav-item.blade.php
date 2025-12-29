<a {{ $attributes->merge() }} href="{{ $href ?? '' }}" class="hover:bg-slate-900 rounded cursor-pointer p-4">{{ $slot }}</a>
