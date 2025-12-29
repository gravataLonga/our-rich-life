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
            <!-- Card 2: Design Minimalista Claro -->
            <div class="bg-white rounded-2xl shadow-lg p-6 max-w-md border border-gray-200">
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
                        <p class="text-2xl font-bold text-gray-800">€2.150</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm mb-1">Meta</p>
                        <p class="text-2xl font-bold text-gray-800">€ {{ $bucket->attr('goal') }}</p>
                    </div>
                </div>

                <div class="bg-gray-200 rounded-full h-2 overflow-hidden">
                    <div class="progress-fill bg-linear-to-r from-green-400 to-green-600 h-full rounded-full" style="width: 43%"></div>
                </div>

                <div class="mt-4 flex items-center justify-between text-sm text-gray-600">
                    <span>Restam €2.850</span>
                    <span>🎯 57% para completar</span>
                </div>
            </div>
        @endforeach
    </div>
</div>
