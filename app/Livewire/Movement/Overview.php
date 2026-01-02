<?php

namespace App\Livewire\Movement;

use App\Models\Movement;
use App\Models\Recording;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class Overview extends Component
{
    public Recording $recording;

    public ?int $movement = null;

    public Collection $movements;

    public function mount(Recording $recording)
    {
        $this->recording = $recording;
        $this->movements = Recording::record(Movement::class)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function store()
    {
        Movement::create([
            'amount' => $this->movement
        ])->recording()->create([
            'parent_id' => $this->recording->id,
        ]);

        $this->movements = Recording::record(Movement::class)
            ->orderBy('created_at', 'desc')
            ->get();

        $this->movement = null;
    }

    public function render()
    {
        return view('livewire.movement.overview');
    }
}
