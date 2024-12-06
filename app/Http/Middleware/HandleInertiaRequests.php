<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Inertia\Middleware;
use Tighten\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $file = lang_path(App::currentLocale() . '.json');
        if (App::currentLocale() !== 'en') {
            $fallbackFile = lang_path('en.json');
            $fallback = File::exists($fallbackFile)
                ? File::json($fallbackFile)
                : [];
        } else {
            $fallback = null;
        }

        $translations = File::exists($file) ? File::json($file) : [];

        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request
                    ->user()
                    ?->load(['tenants', 'tenants.domains']),
                'member' => $request->user()?->asMember(),
            ],
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'ziggy' => fn() => [
                ...(new Ziggy())->toArray(),
                'location' => $request->url(),
            ],
            'locale' => App::currentLocale(),
            'locales' => config('app.available_locales'),
            'translations' => $translations,
            'fallback' => $fallback,
            'centralDomain' => config('tenancy.central_domains')[0],
            'previousUrl' => function () {
                if (
                    url()->previous() !== route('login') &&
                    url()->previous() !== '' &&
                    url()->previous() !== url()->current()
                ) {
                    return url()->previous();
                } else {
                    return null;
                }
            },
            'tenant' => tenant()?->load('domains'),
        ];
    }
}
