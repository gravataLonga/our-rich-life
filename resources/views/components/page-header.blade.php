<div class="flex justify-between items-start">
    <div class="flex flex-col items-start space-y-2">
        <h1 class="font-bold text-4xl text-slate-800 font-sans">{{ $slot }}</h1>
        <x-breadcrumb>
            {{ $breadcrumb }}
        </x-breadcrumb>
    </div>

    @if(!empty($actions))
    <div class="flex space-x-4">
        {{ $actions ?? '' }}
    </div>
    @endif
</div>
