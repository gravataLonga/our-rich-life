<x-card>
    <div class="flex items-start justify-between mb-4">
        <div>
            <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $recording->recordable->name  }}</h3>
        </div>
        <div class="bg-green-100 text-green-700 px-4 py-2 rounded-lg font-bold text-lg">
            {{ round($totalAmount * 100 / $recording->recordable->goal->value(), 2)  }} %
        </div>
    </div>

    <div class="grid grid-cols-2 gap-4 mb-4">
        <div>
            <p class="text-gray-500 text-sm mb-1">Valor Actual</p>
            <p class="text-2xl font-bold text-gray-800">{{ new \OurRichLife\Money($totalAmount)->format('€') }}</p>
        </div>
        <div>
            <p class="text-gray-500 text-sm mb-1">Meta</p>
            <p class="text-2xl font-bold text-gray-800">{{ $recording->recordable->goal->format('€') }}</p>
        </div>
    </div>

    <div class="bg-gray-200 rounded-full h-2 overflow-hidden">
        <div class="progress-fill bg-linear-to-r from-green-400 to-green-600 h-full rounded-full" style="width: {{  clamp(round($totalAmount * 100 / $recording->recordable->goal->value(), 2), 0, 100) }}%"></div>
    </div>

    <div class="flex gap-3 mt-4">
        <x-button.secondary wire:click="movementShow()">
            <span>
                <x-heroicon-o-chart-bar class="w-4 h-4"/>
            </span>
            <span>Movimentos</span>
        </x-button.secondary>
        <x-link.button-tertiary href="{{ route('bucket.form.edit', ['recording' => $recording->id]) }}">
            <span>
                <x-heroicon-o-pencil-square class="w-4 h-4"/>
            </span>
            <span>Edit</span>
        </x-link.button-tertiary>
    </div>



</x-card>
