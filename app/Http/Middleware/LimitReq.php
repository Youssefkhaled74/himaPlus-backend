<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

class LimitReq
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $key = implode('|', [
            'limitReq',
            $request->ip(),
            $request->method(),
            $request->route()?->uri() ?? 'unknown',
        ]);
        $executed = RateLimiter::attempt($key, 300, function (): void {
        }, 60);
        if (! $executed) {
            abort(429, 'Too Many Requests');
        }
        return $next($request);
    }
}
