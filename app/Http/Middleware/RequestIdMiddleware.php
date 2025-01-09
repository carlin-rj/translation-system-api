<?php

namespace App\Http\Middleware;

use App\Helpers\Str;
use Closure;
use Illuminate\Http\Request;

class RequestIdMiddleware
{
    public function handle(Request $request, Closure $next): mixed
    {
        if (! $request->headers->has('X-Request-Id')) {
            $request->headers->set('X-Request-Id', Str::uuid()->toString());
        }
        return $next($request);
    }
}
