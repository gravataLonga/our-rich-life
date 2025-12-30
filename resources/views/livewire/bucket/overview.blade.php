<div class="flex flex-col space-y-10">
    <div class="flex justify-between">
        <h1 class="font-bold text-4xl text-slate-800 font-sans">Bucket List</h1>
        <div class="flex space-x-4">
            <x-link.button-primary>Snapshot</x-link.button-primary>
            <x-link.button-primary wire:navigate href="{{ route('bucket.form.create') }}">Novo Bucket</x-link.button-primary>
        </div>
    </div>

    <div class="grid grid-cols-3 gap-4">
        @foreach($recordings as $recording)
            <livewire:bucket.card wire:key="{{ $recording->recordable->id }}" :$recording />
        @endforeach
    </div>
</div>
