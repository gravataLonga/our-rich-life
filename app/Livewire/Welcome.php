<?php

namespace App\Livewire;

use Livewire\Attributes\Title;
use Livewire\Component;

#[Title("Our Richer Life")]
class Welcome extends Component
{
    public function render()
    {
        return view('livewire.welcome');
    }
}
