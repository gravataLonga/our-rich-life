<input type="{{ $type ?? 'text' }}"
       name="{{ $name ?? '' }}"
       id="{{ $id ?? '' }}"
       value="{{ $value ?? '' }}"
       {{ $attributes->merge() }}
       class="appearance-none bg-white rounded border-2 border-slate-600 text-base text-slate-900 px-2 py-2 focus:outline-2 focus:outline-slate-600 focus:outline-offset-2 w-full">
@if(isset($name))
    @error($name)
        <p>{{ $message }}</p>
    @enderror
@endif
