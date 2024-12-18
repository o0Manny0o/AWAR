<?php

use App\Http\Controllers\Organisation\OrganisationApplicationController;
use Illuminate\Support\Facades\Route;
use App\Http\AppInertia;

Route::middleware(['auth', 'verified'])
    ->prefix('settings')
    ->name('settings.')
    ->group(function () {
        Route::name('applications.')
            ->prefix('applications')
            ->group(function () {
                Route::get('/create/{application}/{step}', [
                    OrganisationApplicationController::class,
                    'createByStep',
                ])->name('create.step');
                Route::post('/{application}/{step}', [
                    OrganisationApplicationController::class,
                    'storeByStep',
                ])->name('store.step');

                Route::patch('/{application}/restore', [
                    OrganisationApplicationController::class,
                    'restore',
                ])->name('restore');
                Route::patch('/{application}/submit', [
                    OrganisationApplicationController::class,
                    'submit',
                ])->name('submit');
            });

        Route::resource(
            'applications',
            OrganisationApplicationController::class,
        );
    });
