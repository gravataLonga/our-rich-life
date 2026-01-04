<div class="flex flex-col space-y-10">

    <x-page-header>
        Manage Bucket

        <x-slot:breadcrumb>
            <x-breadcrumb.item router="welcome">Dashboard</x-breadcrumb.item>
            <x-breadcrumb.separator/>
            <x-breadcrumb.item router="bucket.overview">Bucket</x-breadcrumb.item>
        </x-slot:breadcrumb>

        <x-slot:actions>
            <x-link.button-secondary href="{{ route('bucket.overview') }}">Back</x-link.button-secondary>
        </x-slot:actions>
    </x-page-header>

    <div class="flex gap-4">
        <form class="flex flex-col space-y-4 w-8/12" wire:submit="save">
            @csrf

            <x-card class="flex-col space-y-4">

                <div class="flex items-start justify-between mb-4">
                    <h3 class="text-2xl font-bold text-gray-800 mt-1">
                        @if(!empty($this->recording))
                            Edit a Bucket
                        @else
                            Create a Bucket
                        @endif
                    </h3>
                </div>

                <div class="flex flex-col">
                    <label for="name">
                        Name
                    </label>
                    <x-form.input name="name" wire:model="name" />
                </div>
                <div class="flex flex-col">
                    <label for="goal">
                        Goal
                    </label>
                    <x-form.input name="goal" type="number" wire:model="goal" />
                </div>

                <x-button.primary>
                    Save
                </x-button.primary>
            </x-card>

        </form>
        @if(!empty($recording))
            <div class="w-4/12 flex flex-col space-y-4">
                <div class="flex items-start justify-between mb-4">
                    <h3 class="text-2xl font-bold text-gray-800 mt-1">
                        History
                    </h3>
                </div>
                <div class="flex flex-col space-y-4">
                    @foreach($this->events() as $event)
                        <x-card>
                            <div class="flex flex-col space-y-4">
                                @if($event->recordable_id === $recording->recordable->id)
                                    <div class="bg-green-100 text-green-700 px-4 py-2 rounded-lg text-sm">
                                        current
                                    </div>
                                @endif
                                <div>
                                    <strong>Name</strong>: {{ $event->recordable->name }}<br/>
                                    <strong>Goal</strong>: {{ $event->recordable->goal->format('€') }}
                                    <p class="text-slate-400 text-sm">{{ $event->occurred_at->format('Y, M d H:i:s') }}</p>
                                </div>
                                @if($event->recordable_id !== $recording->recordable->id)
                                <div class="flex justify-between space-x-4 items-start">
                                    <x-button.tertiary type="button" wire:click="recover({{ $event->id }})">Recover</x-button.tertiary>
                                </div>
                                @endif
                            </div>
                        </x-card>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
