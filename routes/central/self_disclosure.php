<?php

use App\Enum\SelfDisclosure\SelfDisclosureStep;
use App\Http\Controllers\SelfDisclosure\SelfDisclosureWizardController;
use App\Http\Middleware\SelfDisclosure\PreventAccessToFutureSteps;
use App\Models\SelfDisclosure\UserExperience;
use App\Models\SelfDisclosure\UserSelfDisclosure;

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
                    Route::patch('/{userFamilyMember}', 'updateFamilyMember')
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
