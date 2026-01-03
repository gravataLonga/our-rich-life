<?php

namespace App\Livewire\Movement;

use App\Models\Movement;
use App\Models\Recording;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class Overview extends Component
{
    public Recording $recordingBucket;

    public ?int $movement = null;

    public Collection $movements;

    public function mount(Recording $recordingBucket)
    {
        $this->recordingBucket = $recordingBucket;
        $this->movements = Recording::record(Movement::class)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function store()
    {
        $this->validate([
            'movement' => 'required|numeric',
        ]);

        Movement::create([
            'amount' => $this->movement
        ])->recording()->create([
            'parent_id' => $this->recordingBucket->id,
        ]);

        $this->movements = Recording::record(Movement::class)
            ->orderBy('created_at', 'desc')
            ->get();

        $this->movement = null;
        $this->dispatch('movement-stored');
    }

    public function render()
    {
        return view('livewire.movement.overview');
    }
}
