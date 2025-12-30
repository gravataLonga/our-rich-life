<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Log;
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
