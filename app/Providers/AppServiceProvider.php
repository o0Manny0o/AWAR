<?php

namespace App\Providers;

use App\Translation\Translator;
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
    }
}
