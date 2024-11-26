<?php

use App\Http\Controllers\Organisation\OrganisationApplicationController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth', 'verified'])
    ->prefix('organisations')
    ->name('organisations.')
    ->group(function () {
        Route::get('/applications/create/{application}/{step}', [OrganisationApplicationController::class, 'createByStep'])->name("applications.create.step");
        Route::post('/applications/{application}/{step}', [OrganisationApplicationController::class, 'storeByStep'])->name("applications.store.step");

        Route::patch('/applications/{application}/restore', [OrganisationApplicationController::class, 'restore'])->name("applications.restore");
        Route::patch('/applications/{application}/submit', [OrganisationApplicationController::class, 'submit'])->name("applications.submit");

        Route::resource('applications', OrganisationApplicationController::class);

    });
