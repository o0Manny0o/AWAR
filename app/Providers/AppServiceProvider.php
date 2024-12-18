<?php

namespace App\Providers;

use App\Translation\Translator;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

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
        Vite::prefetch(concurrency: 3);

        $this->app->extend('translator', function ($service, $app) {
            $translator = new Translator(
                $service->getLoader(),
                $service->getLocale(),
            );
            $translator->setFallback($service->getFallback());

            return $translator;
        });

        Collection::macro('setAppends', function ($attributes) {
            return $this->map(function ($item) use ($attributes) {
                return $item->setAppends($attributes);
            });
        });

        Auth::provider('member', function (Application $app, array $config) {
            return new MemberUserProvider($this->app['hash'], $config['model']);
        });
    }
}
