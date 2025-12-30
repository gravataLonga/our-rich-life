<?php

namespace App\Livewire\Bucket;

use App\Models\Bucket;
use App\Models\Recording;
use Livewire\Component;

class Form extends Component
{
    private ?Recording $recording;

    public ?string $name = null;

    public ?float $goal = null;

    public function mount(?Recording $recording = null)
    {
        $this->recording = $recording;
        $this->goal = $recording?->recordable?->goal?->toNative();
        $this->name = $recording?->recordable?->name;
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|min:3',
            'goal' => 'required|numeric',
        ]);

        Bucket::create(
            $this->only(['name', 'goal'])
        )->recording()->create();

        $this->redirectRoute('bucket.overview');
    }

    public function render()
    {
        return view('livewire.bucket.form');
    }
}
