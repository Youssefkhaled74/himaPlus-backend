<?php

namespace App\Providers;

use App\Models\Info;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer(['layouts.front.*', 'front.*'], function ($view) {
            static $cachedInfo = null;
            static $hasLoaded = false;

            if (!$hasLoaded) {
                try {
                    $cachedInfo = Info::query()
                        ->whereNull('deleted_at')
                        ->where('id', 1)
                        ->first()
                        ?? Info::query()->whereNull('deleted_at')->orderBy('id')->first();
                } catch (\Throwable $exception) {
                    $cachedInfo = null;
                }
                $hasLoaded = true;
            }

            $view->with('siteInfo', $cachedInfo);
        });
    }
}
