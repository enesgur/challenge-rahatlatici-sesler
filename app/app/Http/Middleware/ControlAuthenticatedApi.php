<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Api\Controller;
use Closure;
use Illuminate\Support\Facades\Auth;

class ControlAuthenticatedApi
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param string|null $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard('api')->check()) {
            $controller = new Controller();
            return $controller->responseError(
                'This operation not allowed for logged user',
                null,
                $controller::ERROR_CODE_FORBIDDEN_USER,
                403);
        }

        return $next($request);
    }
}
