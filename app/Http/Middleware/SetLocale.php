<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $headerLocale = $request->header('Lang', $request->header('Accept-Language'));
        if ($headerLocale) {
            $parts = explode('-', $headerLocale);
            $headerLocale = strtolower($parts[0]);
        }

        $sessionLocale = session('locale');

        $userLocale = null;
        if (auth()->check()) {
            $userLocale = auth()->user()->lang;
        }

        $configLocale = config('app.locale', 'en');

        $locale = $sessionLocale ?? $userLocale ?? $headerLocale ?? $configLocale;

        if (in_array($locale, ['en', 'ar'])) {
            App::setLocale($locale);
        } else {
            App::setLocale('en');
        }

        return $next($request);
    }
}

