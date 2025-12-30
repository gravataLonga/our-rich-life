<?php

namespace App\Livewire\Bucket;

use App\Models\Bucket;
use App\Models\Recording;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Buckets')]
class Overview extends Component
{
    public Collection $recordings;

    public function mount()
    {
        $this->recordings = Recording::record(Bucket::class)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function render()
    {
        return view('livewire.bucket.overview');
    }
}
