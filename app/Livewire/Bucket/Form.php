<?php

namespace App\Livewire\Bucket;

use App\Models\Bucket;
use App\Models\Event;
use App\Models\Recording;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title("Bucket Form")]
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
        } else {
            $this->recording = $bucket->recording()->create();
        }

        $bucket->events()->create([
            'recording_id' => $this->recording->id,
            'occurred_at' => now()
        ]);

        $this->redirectRoute('bucket.overview');
    }

    public function recover(Event $event)
    {
        $this->recording = Recording::findOrFail($event->recording_id);
        $this->recording->recordable_id = $event->recordable_id;
        $this->recording->save();
        $this->recording->fresh(['recordable']);

        $this->name = $this->recording->recordable->name;
        $this->goal = $this->recording->recordable->goal->toNative();
    }

    public function render()
    {
        return view('livewire.bucket.form');
    }

    #[Computed]
    public function events()
    {
        return when(
            $this->recording,
            fn() => Event::where('recording_id', $this->recording->id)
                ->with('recordable')
                ->orderBy('occurred_at', 'desc')
                ->get(),
            new Collection()
        );
    }
}
