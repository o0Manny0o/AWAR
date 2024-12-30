<?php

use App\Http\Controllers\Animals\AnimalController;
use App\Http\Controllers\Animals\CatController;
use App\Http\Controllers\Animals\DogController;

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
                ->controller(AnimalController::class)
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
    });
