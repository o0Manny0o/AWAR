<?php

use App\Http\Controllers\Animals\CatController;
use App\Http\Controllers\Animals\DogController;

Route::middleware([])->group(function () {
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
                    ->prefix($name)
                    ->group(function () use ($controller) {
                        Route::post('/{id}/publish', [$controller, 'publish'])
                            ->whereUuid('id')
                            ->name('publish');

                        Route::post('/{id}/assign', [$controller, 'assign'])
                            ->whereUuid('id')
                            ->name('assign.handler');

                        Route::post('/{id}/foster', [
                            $controller,
                            'assignFosterHome',
                        ])
                            ->whereUuid('id')
                            ->name('assign.foster');

                        Route::post('/{id}/location', [
                            $controller,
                            'assignLocation',
                        ])
                            ->whereUuid('id')
                            ->name('assign.location');
                    })
                    ->whereUuid('id');

                Route::resource($name, $controller)
                    ->parameters([
                        $name => 'animal',
                    ])
                    ->whereUuid('animal');
            }
        });
});
