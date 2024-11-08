<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Child;
use App\Observers\ChildObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Child::observe(ChildObserver::class);
    }
}
