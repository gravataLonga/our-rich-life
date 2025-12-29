<form class="flex flex-col space-y-4" wire:submit="store">
    @csrf

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

    <button type="submit" class="bg-lime-400 hover:bg-lime-300 text-slate-800 border-2 border-lime-300 cursor-pointer rounded px-4 py-2 text-base font-semibold">
        create
    </button>
</form>
