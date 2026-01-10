<div class="p-4">
    <table class="w-full mb-10">
        <thead>
            <tr>
                <td class="border-b-2 border-b-stone-200 font-semibold p-2 w-8/12">Amount</td>
                <td class="border-b-2 border-b-stone-200 font-semibold p-2 w-4/12">Date</td>
                <td class="border-b-2 border-b-stone-200 font-semibold p-2 w-4/12"></td>
            </tr>
        </thead>
        <tbody x-data="{show:[]}">
            @forelse($this->movements() as $movement)
                <tr>
                    <td class="border-b-2 border-b-stone-200 font-semibold p-2">{{ $movement->recordable->amount->format('€') }}</td>
                    <td class="border-b-2 border-b-stone-200 font-semibold p-2">{{ $movement->created_at->format('Y, M d') }}</td>
                    <td class="border-b-2 border-b-stone-200 font-semibold p-2">
                        <x-heroicon-o-eye x-show="show.filter((i) => i === {{ $movement->id }}).length <= 0" class="w-4 h-4" @click="show.push({{ $movement->id}})"/>
                        <x-heroicon-o-eye-slash x-show="show.filter((i) => i === {{ $movement->id }}).length > 0" class="w-4 h-4" @click="show = show.filter((i) => i !== {{ $movement->id}})"/>
                    </td>
                </tr>
                <tr x-show="show.find((i) => i === {{ $movement->id }})">
                    <td class="border-b-2 border-b-stone-200 font-semibold p-2 text-slate-500 text-sm" colspan="3">{{ $movement->recordable->notes ?? 'without notes' }}</td>
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

            <div class="flex flex-col space-y-2">
                <x-form.input wire:model="movement" placeholder="amount"/>
                <x-form.textarea wire:model="notes" rows="3" placeholder="write some notes about this transaction"/>
                <div class="grid grid-cols-2 gap-2">
                    <label for="is_snapshot">
                        <input type="checkbox" value="1" wire:model.live="isSnapshot">
                        Snapshot
                    </label>
                    <x-button.primary name="transaction">save</x-button.primary>
                </div>
            </div>
        </form>
    </div>
</div>
