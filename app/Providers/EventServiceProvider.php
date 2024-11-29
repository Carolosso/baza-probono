<?php
namespace App\Providers;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;  // Correct use statement

use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Event;
use App\Listeners\ResetTwoFactorVerified;
use Illuminate\Auth\Events\Login;
use App\Listeners\ResetTwoFactorVerifiedOnLogin;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        // Other events...

        Logout::class => [
            ResetTwoFactorVerified::class,
        ],
        Login::class => [
            ResetTwoFactorVerifiedOnLogin::class,
        ],
    ];
}
