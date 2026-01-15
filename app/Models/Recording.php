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

    protected $fillable = [
        'parent_id',
        'user_id',
    ];

    public static function booted()
    {
        static::creating(function (Model $model): void {
            $model->created_by = auth()->id();
            $model->updated_by = auth()->id();
        });

        static::updating(function (Model $model): void {
            $model->updated_by = auth()->id();
        });
    }

    public function recordable(): MorphTo
    {
        return $this->morphTo();
    }

    #[Scope]
    protected function record(Builder $builder, string $recordable, ?int $parentId = null): void
    {
        $builder->whereMorphedTo('recordable', $recordable)
            ->with('recordable')
            ->when($parentId, fn ($query) => $query->where('parent_id', $parentId));
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
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
