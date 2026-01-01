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
                <x-form.input name="goal" wire:model="goal" />
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
                Histórico
            </h3>
        </div>
        <div class="flex flex-col space-y-4">
            @foreach($events as $event)
                <x-card>
                    <div class="flex flex-col space-y-4">
                        <div>
                            <strong>Name</strong>: {{ $event->recordable->name }}<br/>
                            <strong>Goal</strong>: {{ $event->recordable->goal->format('€') }}
                            <p class="text-slate-400">{{ $event->occurred_at->format('Y, M d H:i:s') }}</p>
                        </div>
                        <x-button.tertiary type="button" wire:click="recover({{ $event->id }})">Recover</x-button.tertiary>
                    </div>
                </x-card>
            @endforeach
        </div>
    </div>
    @endif
</div>
