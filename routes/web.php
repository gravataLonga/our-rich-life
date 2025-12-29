<?php

use Illuminate\Support\Facades\Route;

Route::get('', \App\Livewire\Welcome::class)->name('welcome');
Route::get('/buckets/create', \App\Livewire\Bucket\Create::class)->name('bucket.create');
