<?php

use App\Http\Controllers\Animals\AnimalController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;

Route::middleware(['universal', InitializeTenancyByDomain::class])->group(
    function () {
        Route::prefix('animals')
            ->name('animals.')
            ->controller(AnimalController::class)
            ->group(function () {
                Route::get('/', 'browse')->name('browse');
                Route::get('{animal}', 'showPublic')->name('show');
            });

        Route::get('/language/{language}', function (
            Request $request,
            $language,
        ) {
            $availableLocales = array_map(
                fn($e) => $e['id'],
                config('app.available_locales'),
            );
            if (
                in_array($language, $availableLocales) &&
                $language !== App::currentLocale()
            ) {
                Session()->put('locale', $language);
            }
            if ($request->user()) {
                $request->user()->update(['locale' => $language]);
            }

            return redirect()->back();
        })->name('language');

        require __DIR__ . '/auth.php';
    },
);
