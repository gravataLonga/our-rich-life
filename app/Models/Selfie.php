<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Selfie extends Model
{
    /** @use HasFactory<\Database\Factories\SelfieFactory> */
    use HasFactory;

    protected $casts = [
        'created_at' => 'datetime',
    ];

    protected $guarded = [];
}
