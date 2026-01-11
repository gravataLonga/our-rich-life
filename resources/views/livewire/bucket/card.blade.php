<x-card>
    <div class="flex items-start justify-between mb-4">
        <div>
            <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $recording->recordable->name  }}</h3>
            <p class="mt-1 inline-flex items-center gap-1.5 text-base font-semibold text-gray-600 whitespace-nowrap">
                <x-heroicon-o-flag class="w-4 h-4"/>
                {{ $recording->recordable->goal->format('€') }}
            </p>
        </div>
        <div class="text-right">
            <div class="bg-green-100 text-green-700 px-4 py-2 rounded-lg font-bold text-lg">
                {{ clamp($recording->recordable->calculatePercentage($totalAmount), 0, 500)  }} %
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-y-4 mb-4">
        <div>
            <p class="text-2xl font-bold text-gray-800 whitespace-nowrap">{{ new \OurRichLife\Money($totalAmount)->format('€') }}</p>
            <p class="mt-0.5 text-xs text-gray-500">Valor Actual</p>
        </div>
    </div>

    <div class="bg-gray-200 rounded-full h-2 overflow-hidden">
        <div class="progress-fill bg-linear-to-r from-green-400 to-green-600 h-full rounded-full" style="width: {{  clamp($recording->recordable->calculatePercentage($totalAmount), 0, 100) }}%"></div>
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
