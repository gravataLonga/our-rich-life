<?php

use Illuminate\Support\Facades\Route;

Route::prefix('dashboard')->middleware('auth')->group(function () {
    Route::get('', \App\Livewire\Welcome::class)->name('welcome');
    Route::get('/buckets', \App\Livewire\Bucket\Overview::class)->name('bucket.overview');
    Route::get('/buckets/form', \App\Livewire\Bucket\Form::class)->name('bucket.form.create');
    Route::get('/buckets/{recording}/form', \App\Livewire\Bucket\Form::class)->name('bucket.form.edit');
});
