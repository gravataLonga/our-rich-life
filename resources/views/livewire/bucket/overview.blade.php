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
            <x-card wire:key="{{ $bucket->attr('id') }}">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <span class="text-gray-500 text-sm font-medium">Objetivo Financeiro</span>
                        <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $bucket->attr('name') }}</h3>
                    </div>
                    <div class="bg-green-100 text-green-700 px-4 py-2 rounded-lg font-bold text-lg">
                        43%
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <p class="text-gray-500 text-sm mb-1">Valor Actual</p>
                        <p class="text-2xl font-bold text-gray-800">{{ \OurRichLife\Money::fromNative(1250.50)->format('€') }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm mb-1">Meta</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $bucket->attr('goal')->format('€') }}</p>
                    </div>
                </div>

                <div class="bg-gray-200 rounded-full h-2 overflow-hidden">
                    <div class="progress-fill bg-linear-to-r from-green-400 to-green-600 h-full rounded-full" style="width: 43%"></div>
                </div>

                <div class="flex gap-3 mt-4">
                    <x-link.button-secondary>
                        <span>
                            <x-heroicon-o-pencil-square class="w-4 h-4"/>
                        </span>
                        <span>Edit</span>
                    </x-link.button-secondary>

                    <x-link.button-tertiary>
                        <span>
                            <x-heroicon-o-chart-bar class="w-4 h-4"/>
                        </span>
                        <span>Movimentos</span>
                    </x-link.button-tertiary>
                </div>

            </x-card>
        @endforeach
    </div>
</div>
