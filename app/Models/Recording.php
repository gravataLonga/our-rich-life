<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Recording extends Model
{
    /** @use HasFactory<\Database\Factories\RecordingFactory> */
    use HasFactory;

    public function recordable(): MorphTo
    {
        return $this->morphTo();
    }

    public function isBucket(): bool
    {
        return $this->recordable_type === Bucket::class;
    }

    #[Scope]
    protected function buckets(Builder $builder): void
    {
        $builder->whereMorphedTo('recordable', Bucket::class)
            ->with('recordable');
    }
}
