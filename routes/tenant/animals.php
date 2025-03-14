<?php

use App\Http\Controllers\Animals\CatController;
use App\Http\Controllers\Animals\DogController;
use App\Http\Controllers\Animals\ListingController;
use App\Http\Middleware\SetAnimalTypeMiddleware;
use App\Models\Animal\Cat;
use App\Models\Animal\Dog;

/**
 * Inherited middlewares from tenant routes
 * - auth
 * - verified
 */
Route::name('animals.')
    ->prefix('animals')
    ->group(function () {
        foreach (
            [
                'dogs' => SetAnimalTypeMiddleware::class . ':' . Dog::class,
                'cats' => SetAnimalTypeMiddleware::class . ':' . Cat::class,
            ]
            as $name => $middleware
        ) {
            Route::middleware($middleware)->group(function () use ($name) {
                Route::get($name . '/listings', [
                    ListingController::class,
                    'index',
                ])->name($name . '.listings');
                Route::get($name . '/listings/create', [
                    ListingController::class,
                    'create',
                ])->name($name . '.listings.create');

                Route::name($name . '.')
                    ->prefix($name)
                    ->group(function () {
                        Route::resource('listings', ListingController::class);
                    });

                Route::resource($name . '.listings', ListingController::class)
                    ->parameters([
                        $name => 'animal',
                    ])
                    ->shallow()
                    ->only(['index', 'create'])
                    ->names([
                        'index' => $name . '.listings.index_for',
                        'create' => $name . '.listings.create_for',
                    ]);
            });
        }

        // TODO: Refactor to use animal typed middleware
        foreach (
            [
                'dogs' => DogController::class,
                'cats' => CatController::class,
            ]
            as $name => $controller
        ) {
            Route::name($name . '.')
                ->prefix($name . '/{animal}')
                ->controller($controller)
                ->group(function () {
                    Route::post('/assign', 'assign')->name('assign.handler');

                    Route::post('/foster', 'assignFosterHome')->name(
                        'assign.foster',
                    );

                    Route::post('/location', 'assignLocation')->name(
                        'assign.location',
                    );
                })
                ->whereUuid('animal');

            Route::resource($name, $controller)->parameters([
                $name => 'animal',
            ]);
        }
    });
