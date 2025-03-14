<?php

namespace App\Providers;

use App\Models\Organisation;
use App\Observers\MediaObserver;
use App\Translation\Translator;
use CloudinaryLabs\CloudinaryLaravel\Model\Media;
use Illuminate\Support\Collection;
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
        global_cache()->rememberForever('public_tenant', function () {
            return Organisation::firstOrCreate(['name' => 'public']);
        });

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

        Media::observe(MediaObserver::class);
    }
}
