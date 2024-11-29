<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Auth\Events\Logout; // Correct event

class ResetTwoFactorVerified
{
    /**
     * Handle the event.
     *
     * @param  \Illuminate\Auth\Events\Logout  $event
     * @return void
     */
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Logout $event)
    {
        $user = backpack_user();

        // If user is logged in but their session is invalid, reset 2FA
        if ($user) {
            $user->two_factor_verified = false;
            $user->save();
        }
    }
}
