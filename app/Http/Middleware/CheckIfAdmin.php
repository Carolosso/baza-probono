<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Route;
/**
     * Checked that the logged in user is an administrator.
     *
     * --------------
     * VERY IMPORTANT
     * --------------
     * If you have both regular users and admins inside the same table, change
     * the contents of this method to check that the logged in user
     * is an admin, and not a regular user.
     *
     * Additionally, in Laravel 7+, you should change app/Providers/RouteServiceProvider::HOME
     * which defines the route where a logged in user (but not admin) gets redirected
     * when trying to access an admin route. By default it's '/home' but Backpack
     * does not have a '/home' route, use something you've built for your users
     * (again - users, not admins).
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable|null  $user
     * @return bool
     */
    
class CheckIfAdmin
{
    private function checkIfUserIsAdmin($user)
    {
        return ($user->is_admin == 1);
    }

    private function respondToUnauthorizedRequest($request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            return response(trans('backpack::base.unauthorized'), 401);
        } else {
            return redirect()->guest(backpack_url('login'))
                ->withErrors(['unauthorized' => 'Konto niezatwierdzone. Zaczekaj na zatwierdzenie przez administratora.']);
        }
    }

    public function handle($request, Closure $next)
    {
        // Allow guests to access the login and register pages
        if (Route::is('backpack.auth.login') || Route::is('backpack.auth.register')) {
            return $next($request);
        }

        // Redirect guests to login page if they try to access any other page
        if (backpack_auth()->guest()) {
            return $this->respondToUnauthorizedRequest($request);
        }

        // Restrict access if user is not an admin
        if (! $this->checkIfUserIsAdmin(backpack_user())) {
            backpack_auth()->logout();  // Logout non-admin users immediately
            return $this->respondToUnauthorizedRequest($request);
        }

        return $next($request);
    }
}
