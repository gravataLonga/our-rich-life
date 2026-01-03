<?php

namespace App\Livewire\Bucket;

use App\Models\Bucket;
use App\Models\Movement;
use App\Models\Recording;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Buckets')]
class Overview extends Component
{
    public Collection $recordings;

    public ?Recording $recordingMovements = null;

    public function mount()
    {
        $this->recordings = $this->getRecordings();

    }

    #[On('movementShow')]
    public function movementShowEvent(Recording $recording)
    {
        $this->recordingMovements = $recording;
    }

    public function movementStored()
    {
        $this->recordings = $this->getRecordings();
    }

    #[On('modalClose')]
    public function modalClose()
    {
        $this->recordingMovements = null;
    }

    #[Computed]
    public function showModal()
    {
        return ! is_null($this->recordingMovements);
    }

    public function render()
    {
        return view('livewire.bucket.overview');
    }

    private function getRecordings()
    {
        return Recording::record(Bucket::class)
            ->with(['children' => function ($query) {
                $query->whereMorphedTo('recordable', Movement::class)
                    ->with('recordable');
            }])
            ->orderBy('created_at', 'desc')
            ->get();
    }
}
