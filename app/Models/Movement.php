<?php

namespace App\Models;

use App\Casts\MoneyCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use OurRichLife\Money;

class Movement extends Model
{
    /** @use HasFactory<\Database\Factories\MovementFactory> */
    use HasFactory;

    public $timestamps = false;

    protected $guarded = [];

    protected $casts = [
        'amount' => MoneyCast::class,
        'is_snapshot' => 'boolean',
    ];

    public function recording(): MorphOne
    {
        return $this->morphOne(Recording::class, 'recordable');
    }
}
