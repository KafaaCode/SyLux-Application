<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyDeploySecret
{
    public function handle(Request $request, Closure $next): Response
    {
        $secret = config('deploy.secret');

        if (empty($secret)) {
            abort(404);
        }

        $token = $request->route('token');

        if (!is_string($token) || !hash_equals($secret, $token)) {
            abort(404);
        }

        return $next($request);
    }
}
