<?php

namespace App\Livewire\Movement;

use App\Models\Movement;
use App\Models\Recording;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Overview extends Component
{
    public Recording $recordingBucket;

    public ?int $movement = null;

    public ?string $notes = null;

    public function mount(Recording $recordingBucket)
    {
        $this->recordingBucket = $recordingBucket;
    }

    public function store()
    {
        $this->validate([
            'movement' => 'required|numeric',
            'notes' => 'nullable|string',
        ]);

        Movement::create([
            'amount' => $this->movement,
            'notes' => $this->notes,
        ])->recording()->create([
            'parent_id' => $this->recordingBucket->id,
        ]);

        $this->movement = null;
        $this->notes = null;
        $this->dispatch('movement-stored');
    }

    public function snapshot()
    {
        $this->validate([
            'movement' => 'required|numeric',
            'notes' => 'nullable|string',
        ]);

        dd(
            Recording::with('recordable')
                ->leftJoin('recordings as child_recordings', function ($join) {
                    $join->on('child_recordings.parent_id', '=', $this->recordingBucket->id)
                        ->where('child_recordings.recordable_type', Movement::class);
                })
                ->leftJoin('movements', 'movements.id', '=', 'child_recordings.recordable_id')
                ->select('recordings.*')
                ->selectRaw('COALESCE(SUM(movements.amount), 0) as total_amount')
                ->get()

        );

        Movement::create([
            'amount' => $this->movement,
            'notes' => $this->notes,
        ])->recording()->create([
            'parent_id' => $this->recordingBucket->id,
        ]);

        $this->movement = null;
        $this->notes = null;
        $this->dispatch('movement-stored');
    }

    public function render()
    {
        return view('livewire.movement.overview');
    }

    #[Computed]
    public function movements()
    {
        return Recording::record(Movement::class, $this->recordingBucket->id)
            ->orderBy('created_at', 'desc')
            ->get();
    }
}
