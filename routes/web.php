<?php

use App\Http\Controllers\Animals\AnimalController;
use App\Http\Controllers\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware([
    'universal',
    \Stancl\Tenancy\Middleware\InitializeTenancyByDomain::class,
])->group(function () {
    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name(
            'profile.edit',
        );
        Route::patch('/profile', [ProfileController::class, 'update'])->name(
            'profile.update',
        );
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name(
            'profile.destroy',
        );
    });

    Route::prefix('animals')
        ->name('animals.')
        ->group(function () {
            Route::get('/', [AnimalController::class, 'browse'])->name(
                'browse',
            );
            Route::get('{id}', [AnimalController::class, 'showPublic'])->name(
                'show',
            );
        });

    Route::get('/language/{language}', function (Request $request, $language) {
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
});
