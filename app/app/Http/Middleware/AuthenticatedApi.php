<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Api\Controller;
use Closure;
use Illuminate\Support\Facades\Auth;

class AuthenticatedApi
{
    /**
     * @param $request
     * @param Closure $next
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function handle($request, Closure $next)
    {
        $header = $request->header('Authorization', '');
        $header = explode('Bearer ', $header);
        $token = $header[1] ?? null;

        if ($token === null) {
            $controller = new Controller();
            return $controller->responseError('Authentication (Bearer token) is required.', 401);
        }

        if (Auth::guard('api')->check() === false) {
            $controller = new Controller();
            return $controller->responseError('Authentication error.', 401);
        }

        return $next($request);
    }
}
