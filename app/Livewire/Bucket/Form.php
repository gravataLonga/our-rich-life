<?php

namespace App\Livewire\Bucket;

use App\Models\Bucket;
use App\Models\Event;
use App\Models\Recording;
use Livewire\Component;

class Form extends Component
{
    public ?Recording $recording = null;

    public ?string $name = null;

    public ?float $goal = null;

    public function mount(?Recording $recording = null)
    {
        $this->recording = $recording;
        $this->goal = $recording?->recordable?->goal?->toNative();
        $this->name = $recording?->recordable?->name;
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
            Event::create([
                'recording_id' => $this->recording->id,
                'recordable_id' => $this->recording->recordable->id,
                'occurred_at' => now()
            ]);
        } else {
            $recording = $bucket->recording()->create();
            Event::create([
                'recording_id' => $recording->id,
                'recordable_id' => $bucket->id,
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
