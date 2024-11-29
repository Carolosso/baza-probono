<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class TwoFactorMiddleware
{
    public function handle($request, Closure $next)
    {       
        $user = backpack_user();

        if (!$user->two_factor_enabled) {
            return redirect()->route('2fa.setup');
        }

        if ($user->two_factor_enabled && !$user->two_factor_verified) {
            return redirect()->route('2fa.verify');
        }

        return $next($request);
    }
}
