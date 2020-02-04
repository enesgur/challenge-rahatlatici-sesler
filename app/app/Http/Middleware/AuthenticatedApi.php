<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Api\Controller;
use Closure;
use Illuminate\Support\Facades\Auth;

class AuthenticatedApi
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard('api')->check() === false) {
            $controller = new Controller();
            return $controller->responseError('Authentication error.', 401);
        }

        return $next($request);
    }
}
