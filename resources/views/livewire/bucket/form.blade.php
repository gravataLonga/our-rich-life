<form class="flex flex-col space-y-4" wire:submit="save">
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

    <x-button.primary>
        Save
    </x-button.primary>

</form>
