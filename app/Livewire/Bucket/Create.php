<?php

namespace App\Livewire\Bucket;

use App\Models\Bucket;
use App\Models\Recording;
use Livewire\Component;

class Create extends Component
{
    public ?string $name = null;

    public ?string $goal = null;

    public function store()
    {
        $this->validate([
            'name' => 'required|min:3',
            'goal' => 'required|numeric',
        ]);

        Bucket::create(
            $this->only(['name', 'goal'])
        )->recording()->create();

        return $this->redirect('/bucket');
    }

    public function render()
    {
        return view('livewire.bucket.create');
    }
}
