<?php

namespace App\Livewire;

use App\Models\Selfie;
use Livewire\Component;

class Selfies extends Component
{
    public ?string $account = 'Caixa Geral Deposito';

    public ?int $id = null;

    public ?int $amount = null;

    public function mount(Selfie $selfie)
    {
        $this->fill($selfie->only(['id', 'amount']));
    }

    public function render()
    {
        return view('livewire.selfies');
    }
}
