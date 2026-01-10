<?php

namespace App\Livewire\Movement;

use App\Models\Bucket;
use App\Models\Movement;
use App\Models\Recording;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;
use OurRichLife\Money;

class Overview extends Component
{
    public Recording $recordingBucket;

    public ?float $movement = null;

    public ?string $notes = null;

    public ?bool $isSnapshot = false;

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

        $totalAmount = Recording::query()
            ->leftJoin('movements', 'movements.id', '=', 'recordings.recordable_id')
            ->where('recordings.parent_id', $this->recordingBucket->id)
            ->selectRaw('COALESCE(SUM(movements.amount), 0) as total_amount')
            ->groupBy('recordings.parent_id')
            ->value('total_amount');

        $total = when(
            boolval($this->isSnapshot),
            Money::fromNative($this->movement)->sub(new Money($totalAmount)),
            $this->movement
        );

        Movement::create([
            'amount' => $total,
            'notes' => when($this->isSnapshot, '(snapshot) ' . $this->notes, $this->notes),
            'is_snapshot' => $this->isSnapshot,
        ])->recording()->create([
            'parent_id' => $this->recordingBucket->id,
        ]);

        $this->movement = null;
        $this->notes = null;
        $this->isSnapshot = false;
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
