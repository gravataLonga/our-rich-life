<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;

Route::get('/', AuthenticatedSessionController::class.'@create');

Route::prefix('dashboard')->middleware('auth')->group(function (): void {
    Route::get('', \App\Livewire\Welcome::class)->name('welcome');
    Route::get('/buckets', \App\Livewire\Bucket\Overview::class)->name('bucket.overview');
    Route::get('/buckets/form', \App\Livewire\Bucket\Form::class)->name('bucket.form.create');
    Route::get('/buckets/{recording}/form', \App\Livewire\Bucket\Form::class)->name('bucket.form.edit')->middleware('can:update,recording');
});
