<div class="flex flex-col space-y-10">

    <x-page-header>
        Bucket List

        <x-slot:breadcrumb>
            <x-breadcrumb.item router="welcome">Dashboard</x-breadcrumb.item>
            <x-breadcrumb.separator/>
            <x-breadcrumb.item router="bucket.overview">Bucket</x-breadcrumb.item>
        </x-slot:breadcrumb>

        <x-slot:actions>
            <x-link.button-secondary>Snapshot</x-link.button-secondary>
            <x-link.button-primary wire:navigate href="{{ route('bucket.form.create') }}">Novo Bucket</x-link.button-primary>
        </x-slot:actions>

    </x-page-header>

    <div class="grid grid-cols-3 gap-4 pb-8">
        @foreach($this->recordings as $recording)
            <livewire:bucket.card wire:key="{{ $recording->id }}" :$recording />
        @endforeach
    </div>

    @if($this->showModal())
        @teleport('body')
            <x-modal>
                <livewire:movement.overview :$recordingBucket />
            </x-modal>
        @endteleport
    @endif
</div>
