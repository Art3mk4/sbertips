<?php

namespace SushiMarket\Sbertips\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class SbertipsAuthMiddleware
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse) $next
     * @return mixed
     */
    public function handle(\Illuminate\Http\Request $request, Closure $next)
    {
        if ($request->bearerToken() !== config('sbertips.auth.bearerToken')) {
            return response()->json(["status" => "error", "message" => "Unauthorized"], 401);
        }

        return $next($request);
    }
}
