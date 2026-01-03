<?php

namespace App\Livewire\Bucket;

use App\Models\Bucket;
use App\Models\Recording;
use Illuminate\Log\Logger;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Card extends Component
{
    public Recording $recording;

    public ?int $totalAmount = null;

    public function mount(Recording $recording)
    {
        $this->recording = $recording;
        $this->totalAmount = $recording->total_amount;
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
