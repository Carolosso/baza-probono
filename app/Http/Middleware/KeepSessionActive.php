<?php
namespace App\Http\Middleware;

use Closure;

class KeepSessionActive
{
    public function handle($request, Closure $next)
    {
        // This will refresh session lifetime
        session()->reflash();
        return $next($request);
    }
}
