<?php

use App\Http\Controllers\Tenant\MemberController;
use App\Http\Controllers\Tenant\OrganisationInvitationController;
use App\Http\Controllers\Tenant\OrganisationLocationController;
use App\Http\Controllers\Tenant\Settings\OrganisationSettingsController;

Route::name('settings.')
    ->prefix('settings')
    ->group(function () {
        Route::name('invitations.')
            ->prefix('invitations')
            ->group(function () {
                Route::post('/resend/{id}', [
                    OrganisationInvitationController::class,
                    'resend',
                ])->name('resend');
            });

        Route::resource(
            'invitations',
            OrganisationInvitationController::class,
        )->except(['edit', 'update', 'destroy']);

        Route::resource('members', MemberController::class)->only(['index']);

        Route::resource('locations', OrganisationLocationController::class);

        Route::controller(OrganisationSettingsController::class)->group(
            function () {
                Route::name('favicon.')
                    ->prefix('favicon')
                    ->group(function () {
                        Route::get('/edit', 'editFavicon')->name('edit');
                        Route::post('/update', 'updateFavicon')->name('update');
                    });

                Route::name('logo.')
                    ->prefix('logo')
                    ->group(function () {
                        Route::get('/edit', 'editLogo')->name('edit');
                        Route::post('/update', 'updateLogo')->name('update');
                    });

                Route::name('public.')
                    ->prefix('public')
                    ->group(function () {
                        Route::get('/', 'show')->name('show');
                        Route::get('/edit', 'edit')->name('edit');
                        Route::patch('/update', 'update')->name('update');
                    });
            },
        );
    });
