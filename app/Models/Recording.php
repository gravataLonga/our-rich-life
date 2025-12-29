<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
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


    #[Scope]
    protected function record(Builder $builder, string $recordable): void
    {
        $builder->whereMorphedTo('recordable', $recordable)
            ->with('recordable');
    }

    public function isRecordable(string $recordableClass): bool
    {
        return $this->recordable_type === $recordableClass;
    }

    public function attr(string $key, mixed $default = null): mixed
    {
        return data_get($this->recordable, $key, $default);
    }
}
