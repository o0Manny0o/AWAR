<?php

use App\Enum\SelfDisclosure\SelfDisclosureStep;
use App\Http\AppInertia;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SelfDisclosure\SelfDisclosureWizardController;
use App\Http\Middleware\SelfDisclosure\PreventAccessToFutureSteps;
use App\Models\SelfDisclosure\UserExperience;
use App\Models\SelfDisclosure\UserSelfDisclosure;

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
        return AppInertia::render('Public/Dashboard');
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

    Route::prefix('self-disclosure')->group(function () {
        Route::get('/', [
            SelfDisclosureWizardController::class,
            'redirectToCurrentStep',
        ])->name('self-disclosure');

        Route::get('/complete', [
            SelfDisclosureWizardController::class,
            'showComplete',
        ])
            ->name('self-disclosure.complete')
            ->middleware(
                PreventAccessToFutureSteps::class .
                    ':' .
                    SelfDisclosureStep::COMPLETE->value,
            );

        Route::name('self-disclosure.')
            ->middleware(['can:useWizard,' . UserSelfDisclosure::class])
            ->group(function () {
                foreach (SelfDisclosureStep::formStepValues() as $step) {
                    Route::get('/' . $step, [
                        SelfDisclosureWizardController::class,
                        'show' . ucfirst($step) . 'Step',
                    ])
                        ->name($step . '.show')
                        ->middleware(
                            PreventAccessToFutureSteps::class . ':' . $step,
                        );

                    Route::patch('/' . $step, [
                        SelfDisclosureWizardController::class,
                        'update' . ucfirst($step),
                    ])
                        ->name($step . '.update')
                        ->middleware(
                            PreventAccessToFutureSteps::class . ':' . $step,
                        );
                }

                Route::prefix('family-members')
                    ->name('family-members.')
                    ->middleware(
                        PreventAccessToFutureSteps::class .
                            ':' .
                            SelfDisclosureStep::FAMILY->value,
                    )
                    ->controller(SelfDisclosureWizardController::class)
                    ->group(function () {
                        Route::get('/', 'createFamilyMember')
                            ->can('create', 'userFamilyMember')
                            ->name('create');

                        Route::post('/', 'storeFamilyMember')
                            ->can('create', 'userFamilyMember')
                            ->name('store');
                        Route::get('/{userFamilyMember}', 'editFamilyMember')
                            ->can('update', 'userFamilyMember')
                            ->name('edit');
                        Route::patch(
                            '/{userFamilyMember}',
                            'updateFamilyMember',
                        )
                            ->can('update', 'userFamilyMember')
                            ->name('update');
                        Route::delete('/{userFamilyMember}', [
                            SelfDisclosureWizardController::class,
                            'destroyFamilyMember',
                        ])
                            ->can('delete', 'userFamilyMember')
                            ->name('destroy');
                    });

                Route::prefix('experience')
                    ->name('experience.')
                    ->middleware(
                        PreventAccessToFutureSteps::class .
                            ':' .
                            SelfDisclosureStep::EXPERIENCES->value,
                    )
                    ->group(function () {
                        Route::get('/', [
                            SelfDisclosureWizardController::class,
                            'createExperience',
                        ])
                            ->can('create', UserExperience::class)
                            ->name('create');
                        Route::post('/', [
                            SelfDisclosureWizardController::class,
                            'storeExperience',
                        ])
                            ->can('create', UserExperience::class)
                            ->name('store');
                        Route::get('/{userExperience}', [
                            SelfDisclosureWizardController::class,
                            'editExperience',
                        ])
                            ->can('update', 'userExperience')
                            ->name('edit');
                        Route::patch('/{userExperience}', [
                            SelfDisclosureWizardController::class,
                            'updateExperience',
                        ])
                            ->can('update', 'userExperience')
                            ->name('update');
                        Route::delete('/{userExperience}', [
                            SelfDisclosureWizardController::class,
                            'destroyExperience',
                        ])
                            ->can('delete', 'userExperience')
                            ->name('destroy');
                    });
            });
    });
});
