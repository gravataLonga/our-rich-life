<div class="flex flex-col space-y-10">
    <div class="flex justify-between">
        <h1 class="font-bold text-4xl text-slate-800 font-sans">Bucket List</h1>
        <div class="flex space-x-4">
            <x-link.button-primary>Snapshot</x-link.button-primary>
            <x-link.button-primary wire:navigate href="{{ route('bucket.create') }}">Novo Bucket</x-link.button-primary>
        </div>
    </div>

    <div class="grid grid-cols-3 gap-4">
        @foreach($buckets as $bucket)
            <x-panel wire:key="{{ $bucket->id }}">

                <x-slot:header>
                    {{ $bucket->attr('name') }}
                </x-slot:header>

                <div class="flex items-end justify-between">
                    <h6 class="text-4xl text-slate-800">{{ $bucket->attr('goal', 0) }} €</h6>
                </div>
            </x-panel>
        @endforeach
    </div>
</div>
