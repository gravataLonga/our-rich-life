<?php

namespace App\Livewire\Bucket;

use App\Models\Bucket;
use App\Models\Recording;
use Illuminate\Log\Logger;
use Livewire\Component;

class Card extends Component
{
    public Recording $recording;

    public function mount(Recording $recording)
    {
        $this->recording = $recording;
    }

    public function render()
    {
        return view('livewire.bucket.card');
    }

    public function movementShow()
    {
        $this->dispatch('movementShow', recordingId: $this->recording->id);
    }
}
