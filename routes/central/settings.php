<?php

use App\Http\Controllers\Organisation\OrganisationApplicationController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])
    ->prefix('settings')
    ->name('settings.')
    ->group(function () {
        Route::name('applications.')
            ->prefix('applications')
            ->controller(OrganisationApplicationController::class)
            ->group(function () {
                Route::get(
                    '/create/{application}/{step}',
                    'createByStep',
                )->name('create.step');
                Route::post('/{application}/{step}', 'storeByStep')->name(
                    'store.step',
                );

                Route::patch('/{application}/restore', 'restore')->name(
                    'restore',
                );
                Route::patch('/{application}/submit', 'submit')->name('submit');
            });

        Route::resource(
            'applications',
            OrganisationApplicationController::class,
        );
    });
