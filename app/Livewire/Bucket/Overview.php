<?php

namespace App\Livewire\Bucket;

use App\Models\Bucket;
use App\Models\Recording;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class Overview extends Component
{
    public Collection $buckets;

    public function mount()
    {
        $this->buckets = Recording::record(Bucket::class)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function render()
    {
        return view('livewire.bucket.overview');
    }
}
