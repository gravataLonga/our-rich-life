<div class="flex flex-col space-y-10">

    <x-page-header>
        Bucket List

        <x-slot:breadcrumb>
            <x-breadcrumb.item router="welcome">Dashboard</x-breadcrumb.item>
            <x-breadcrumb.seperator/>
            <x-breadcrumb.item router="bucket.overview">Bucket</x-breadcrumb.item>
        </x-slot:breadcrumb>

        <x-slot:actions>
            <x-link.button-secondary>Snapshot</x-link.button-secondary>
            <x-link.button-primary wire:navigate href="{{ route('bucket.form.create') }}">Novo Bucket</x-link.button-primary>
        </x-slot:actions>

    </x-page-header>

    <div class="flex justify-between">
        <h1 class="font-bold text-4xl text-slate-800 font-sans"></h1>
        <div class="flex space-x-4">
        </div>
    </div>

    <div class="grid grid-cols-3 gap-4">
        @foreach($recordings as $recording)
            <livewire:bucket.card wire:key="{{ $recording->recordable->id }}" :$recording />
        @endforeach
    </div>
</div>
