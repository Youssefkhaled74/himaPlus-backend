<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        // 1. قراءة من session
        $sessionLocale = session('locale');
        Log::info('SetLocale: Session locale = ' . ($sessionLocale ?? 'NULL'));

        // 2. قراءة من user
        $userLocale = null;
        if (auth()->check()) {
            $userLocale = auth()->user()->lang;
            Log::info('SetLocale: User is logged in, user lang = ' . ($userLocale ?? 'NULL'));
        } else {
            Log::info('SetLocale: User is NOT logged in');
        }

        // 3. قراءة من config
        $configLocale = config('app.locale', 'en');
        Log::info('SetLocale: Config locale = ' . $configLocale);

        // 4. تحديد اللوكيل النهائي
        $locale = $sessionLocale ?? $userLocale ?? $configLocale;
        Log::info('SetLocale: Final locale selected = ' . $locale);

        // 5. التحقق من أن اللوكيل صحيح
        if (in_array($locale, ['en', 'ar'])) {
            App::setLocale($locale);
            Log::info('SetLocale: Locale set to ' . $locale);
        } else {
            Log::warning('SetLocale: Invalid locale "' . $locale . '", using default "en"');
            App::setLocale('en');
        }

        Log::info('SetLocale: Final app locale = ' . App::getLocale());

        return $next($request);
    }
}

