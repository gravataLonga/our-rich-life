<?php

namespace App\Livewire\Bucket;

use App\Models\Bucket;
use App\Models\Event;
use App\Models\Recording;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class Form extends Component
{
    public ?Recording $recording = null;

    public ?string $name = null;

    public ?float $goal = null;
    public Collection $events;

    public function mount(?Recording $recording = null)
    {
        $this->recording = $recording;
        $this->goal = $recording?->recordable?->goal?->toNative();
        $this->name = $recording?->recordable?->name;
        if (!is_null($this->recording)) {
            $this->events = Event::where('recording_id', $this->recording->id)
                ->with('recordable')
                ->orderBy('occurred_at', 'desc')
                ->get();
        }
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|min:3',
            'goal' => 'required|numeric',
        ]);

        $bucket = Bucket::create(
            $this->only(['name', 'goal'])
        );

        if ($this->recording) {
            $this->recording->recordable()->associate($bucket)->save();
            $bucket->events()->create([
                'recording_id' => $this->recording->id,
                'occurred_at' => now()
            ]);
        } else {
            $this->recording = $bucket->recording()->create();
            $bucket->events()->create([
                'recording_id' => $this->recording->id,
                'occurred_at' => now()
            ]);
        }

        $this->redirectRoute('bucket.overview');
    }

    public function render()
    {
        return view('livewire.bucket.form');
    }
}
