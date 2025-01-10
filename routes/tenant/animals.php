<?php

use App\Http\Controllers\Animals\AnimalListingController;
use App\Http\Controllers\Animals\CatController;
use App\Http\Controllers\Animals\DogController;
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
                'dogs' => DogController::class,
                'cats' => CatController::class,
            ]
            as $name => $controller
        ) {
            Route::name($name . '.')
                ->prefix($name . '/{animal}')
                ->controller($controller)
                ->group(function () {
                    Route::post('/publish', 'publish')->name('publish');

                    Route::post('/assign', 'assign')->name('assign.handler');

                    Route::post('/foster', 'assignFosterHome')->name(
                        'assign.foster',
                    );

                    Route::post('/location', 'assignLocation')->name(
                        'assign.location',
                    );
                });

            Route::resource($name, $controller)->parameters([
                $name => 'animal',
            ]);
        }

        foreach (
            [
                'dogs' => SetAnimalTypeMiddleware::class . ':' . Dog::class,
                'cats' => SetAnimalTypeMiddleware::class . ':' . Cat::class,
            ]
            as $name => $middleware
        ) {
            Route::middleware($middleware)->group(function () use ($name) {
                Route::name('listings.')
                    ->prefix('listings')
                    ->group(function () use ($name) {
                        Route::resource(
                            $name,
                            AnimalListingController::class,
                        )->parameters([
                            $name => 'animal',
                        ]);
                    });
            });
        }
    });
