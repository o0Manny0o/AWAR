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
                ])->name($step . '.show');

                Route::patch('/' . $step, [
                    SelfDisclosureWizardController::class,
                    'update' . ucfirst($step),
                ])->name($step . '.update');
            }

            Route::prefix('family-members')
                ->name('family-members.')
                ->group(function () {
                    Route::get('/', [
                        SelfDisclosureWizardController::class,
                        'createFamilyMember',
                    ])->name('create');
                    Route::post('/', [
                        SelfDisclosureWizardController::class,
                        'storeFamilyMember',
                    ])->name('store');
                    Route::get('/{userFamilyMember}', [
                        SelfDisclosureWizardController::class,
                        'editFamilyMember',
                    ])->name('edit');
                    Route::patch('/{userFamilyMember}', [
                        SelfDisclosureWizardController::class,
                        'updateFamilyMember',
                    ])->name('update');
                    Route::delete('/{userFamilyMember}', [
                        SelfDisclosureWizardController::class,
                        'destroyFamilyMember',
                    ])->name('destroy');
                });

            Route::prefix('experience')
                ->name('experience.')
                ->group(function () {
                    Route::get('/', [
                        SelfDisclosureWizardController::class,
                        'createExperience',
                    ])->name('create');
                    Route::post('/', [
                        SelfDisclosureWizardController::class,
                        'storeExperience',
                    ])->name('store');
                    Route::get('/{userExperience}', [
                        SelfDisclosureWizardController::class,
                        'editExperience',
                    ])->name('edit');
                    Route::patch('/{userExperience}', [
                        SelfDisclosureWizardController::class,
                        'updateExperience',
                    ])->name('update');
                    Route::delete('/{userExperience}', [
                        SelfDisclosureWizardController::class,
                        'destroyExperience',
                    ])->name('destroy');
                });

            Route::redirect('/', '/self-disclosure/personal');
        });
});
