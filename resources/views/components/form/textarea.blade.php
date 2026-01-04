<textarea
    class="appearance-none bg-white rounded border-2 border-slate-600 text-base text-slate-900 px-2 py-2 focus:outline-2 focus:outline-slate-600 focus:outline-offset-2 w-full"
    {{ $attributes->merge() }}
    name="{{ $name ?? '' }}"
    id="{{ $id ?? '' }}"
    rows="{{ $rows ?? 10 }}">{{ when(isset($name), fn () => old($name, $value ?? ''), '') }}</textarea>
@if(isset($name))
    @error($name)
    <p>{{ $message }}</p>
    @enderror
@endif
