<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Declaration;
use App\Observers\DeclarationObserver;

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
        Declaration::observe(DeclarationObserver::class);
    }
}
