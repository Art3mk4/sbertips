<?php

namespace SushiMarket\Sbertips\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class SbertipsAuthMiddleware
{
    /**
     * @param Request $request
     * @param \Closure(Request): (Response|RedirectResponse) $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->bearerToken() !== config('sbertips.auth.bearerToken')) {
            return response()->json(["status" => "error", "message" => "Unauthorized"], 401);
        }

        return $next($request);
    }
}
