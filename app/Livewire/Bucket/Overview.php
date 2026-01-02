<?php

namespace App\Livewire\Bucket;

use App\Models\Bucket;
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
        $this->recordings = Recording::record(Bucket::class)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    #[On('movementShow')]
    public function movementShowEvent(Recording $recording)
    {
        $this->recordingMovements = $recording;
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
}
