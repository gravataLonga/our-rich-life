<a {{ $attributes->merge() }} href="{{ $router ? route($router) : '#'  }}" class="text-slate-500">{{ $slot }}</a>
