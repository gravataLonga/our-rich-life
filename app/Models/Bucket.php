<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bucket extends Model
{
    /** @use HasFactory<\Database\Factories\BucketFactory> */
    use HasFactory;

    public $timestamps = false;

    protected $guarded = [];

    public function recording()
    {
        return $this->morphOne(Recording::class, 'record');
    }
}
