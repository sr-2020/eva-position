<?php

namespace App\Providers;

use App\Functions\Functions;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Functions::class, function () {
            return new Functions(config('services.functions'));
        });
    }
}
