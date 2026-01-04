<div class="p-4">
    <table class="w-full mb-10">
        <thead>
            <tr>
                <td class="border-b-2 border-b-stone-200 font-semibold p-2 w-8/12">Amount</td>
                <td class="border-b-2 border-b-stone-200 font-semibold p-2 w-4/12">Date</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            @forelse($this->movements() as $movement)
                <tr>
                    <td class="border-b-2 border-b-stone-200 font-semibold p-2">{{ $movement->recordable->amount->format('€') }}</td>
                    <td class="border-b-2 border-b-stone-200 font-semibold p-2">{{ $movement->created_at->format('Y, M d') }}</td>
                    <td></td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center text-stone-400 px-4 py-4">
                        without movements
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div class="w-full">
        <form wire:submit="store">
            @csrf

            <div class="flex space-x-4">
                <x-form.input wire:model="movement" placeholder="amount"/>
                <x-button.primary>save</x-button.primary>
            </div>
        </form>
    </div>
</div>
