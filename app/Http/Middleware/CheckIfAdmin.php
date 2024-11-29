<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Route;

class CheckIfAdmin
{
    /**
     * Check if the logged-in user is an admin.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable|null  $user
     * @return bool
     */
    private function checkIfUserIsAdmin($user)
    {
        return $user && $user->is_admin;
    }

    /**
     * Handle unauthorized requests.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    private function respondToUnauthorizedRequest($request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            return response(['error' => trans('backpack::base.unauthorized')], 401);
        }
        else{
                return redirect()->guest(backpack_url('login'))->withErrors(['unauthorized' => 'Odmowa dostępu. Odśwież stronę i spróbuj ponownie.  
                W przeciwnym wypadku konto może być niezatwierdzone. Zaczekaj na zatwierdzenie przez administratora.']);
        }
        
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Allow guests to access login and register pages
        if (Route::is('backpack.auth.login') || Route::is('backpack.auth.register')) {
            return $next($request);
        }

        // Check if the user is authenticated
        if (backpack_auth()->guest()) {
            return $this->respondToUnauthorizedRequest($request);
        }

        $user = backpack_user();

        // Check if the user is an admin
        if (! $this->checkIfUserIsAdmin($user)) {
            backpack_auth()->logout();
            return $this->respondToUnauthorizedRequest($request);
        }

        return $next($request);
    }
}
