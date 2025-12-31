<?php

namespace App\Models;

use App\Casts\MoneyCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Bucket extends Model
{
    /** @use HasFactory<\Database\Factories\BucketFactory> */
    use HasFactory;

    public $timestamps = false;

    protected $guarded = [];

    protected $casts = [
        'goal' => MoneyCast::class,
    ];

    public function recording(): MorphOne
    {
        return $this->morphOne(Recording::class, 'recordable');
    }

    public function events(): MorphOne
    {
        return $this->morphOne(Event::class, 'recordable');
    }
}
