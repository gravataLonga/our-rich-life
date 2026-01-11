<?php

namespace App\Models;

use App\Casts\MoneyCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use OurRichLife\Money;

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

    public function calculatePercentage(? float $money): float
    {
        if ($money <= 0 || is_null($money)) {
            return 0;
        }

        $total = $money * 100 / $this->goal->value();

        return round($total, 2);
    }
}
