<?php

namespace App\Livewire\Bucket;

use App\Models\Bucket;
use App\Models\Movement;
use App\Models\Recording;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Buckets')]
class Overview extends Component
{
    public ?Recording $recordingBucket = null;

    #[On('movementShow')]
    public function movementShowEvent(int $recordingId)
    {
        $this->recordingBucket = $this->recordings->firstWhere('id', $recordingId);
    }

    #[On('modalClose')]
    public function modalClose()
    {
        $this->recordingBucket = null;
    }

    #[On('movement-stored')]
    public function movementStored()
    {
    }

    #[Computed]
    public function showModal()
    {
        return ! is_null($this->recordingBucket);
    }

    public function render()
    {
        return view('livewire.bucket.overview');
    }

    #[Computed]
    public function recordings()
    {
        return $this->getRecordings();
    }

    private function getRecordings()
    {
        return Recording::record(Bucket::class)
                ->where('recordings.user_id', auth()->id())
                ->leftJoin('recordings as child_recordings', function ($join): void {
                    $join->on('child_recordings.parent_id', '=', 'recordings.id')
                        ->where('child_recordings.recordable_type', Movement::class);
                })
                ->leftJoin('movements', 'movements.id', '=', 'child_recordings.recordable_id')
                ->select('recordings.*')
                ->selectRaw('COALESCE(SUM(movements.amount), 0) as total_amount')
                ->groupBy('recordings.id')
                ->with('recordable')
                ->orderBy('recordings.created_at', 'desc')
                ->get();
    }
}
