<?php

use App\Http\AppInertia;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SelfDisclosure\SelfDisclosureWizardController;

Route::get('/', function () {
    return AppInertia::render('Welcome');
})->name('landing-page');

Route::get('/about', function () {
    return AppInertia::render('Welcome');
})->name('about');

Route::get('/pricing', function () {
    return AppInertia::render('Welcome');
})->name('pricing');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return AppInertia::render('Dashboard');
    })->name('dashboard');

    Route::prefix('settings')
        ->name('settings.')
        ->group(function () {
            Route::get('/profile', [ProfileController::class, 'edit'])->name(
                'profile.edit',
            );
            Route::patch('/profile', [
                ProfileController::class,
                'update',
            ])->name('profile.update');
            Route::delete('/profile', [
                ProfileController::class,
                'destroy',
            ])->name('profile.destroy');

            return redirect('settings/profile');
        });

    Route::prefix('self-disclosure')
        ->name('self-disclosure.')
        ->group(function () {
            foreach (SelfDisclosureWizardController::$steps as $step) {
                Route::get('/' . $step, [
                    SelfDisclosureWizardController::class,
                    'show' . ucfirst($step) . 'Step',
                ])->name($step);
            }

            Route::redirect('/', '/self-disclosure/personal');
        });
});
