<?php

declare(strict_types=1);

use App\Http\Controllers\Tenant\MemberController;
use App\Http\Controllers\Tenant\OrganisationInvitationController;
use App\Models\Tenant\Member;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

Route::middleware([
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    Route::get('/', function () {
        return Inertia::render('Welcome', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
        ]);
    })->name('tenant.landing-page');

    Route::get('invitations/accept/{token}', [
        OrganisationInvitationController::class,
        'accept',
    ])->name('organisation.invitations.accept');

    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('/dashboard', function () {
            Gate::authorize('viewAny', Member::class);
            $members = Member::with('roles')->get();
            return Inertia::render('Tenant/Dashboard', [
                'members' => $members,
            ]);
        })->name('tenant.dashboard');

        Route::name('organisation.')->group(function () {
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

            Route::resource('members', MemberController::class)->only([
                'index',
            ]);
        });
    });
});
