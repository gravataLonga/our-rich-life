<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Model::preventLazyLoading(! $this->app->isProduction());
        //
        Blueprint::macro('metadata', function () {
            $this->unsignedBigInteger('created_by');
            $this->unsignedBigInteger('updated_by');
            $this->unsignedBigInteger('deleted_by')->nullable();
            $this->timestamps();
            $this->softDeletes();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
