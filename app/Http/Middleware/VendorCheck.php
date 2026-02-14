<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VendorCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated and has user_type = 2 (vendor)
        if (auth()->check() && auth()->user()->user_type == 2) {
            return $next($request);
        }
        
        // If not vendor, redirect to login
        flash()->error('You do not have access to this page.');
        return redirect(route('vendor/login'));
    }
}
