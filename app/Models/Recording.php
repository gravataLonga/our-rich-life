<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Recording extends Model
{
    /** @use HasFactory<\Database\Factories\RecordingFactory> */
    use HasFactory;

    public function recordable(): MorphTo
    {
        return $this->morphTo();
    }

    public function isSelfie(): bool
    {
        return $this->recordable_type === Selfie::class;
    }

    #[Scope]
    protected function selfies(Builder $builder): void
    {
        $builder->where('recording_type', Selfie::class);
    }
}
