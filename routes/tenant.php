<?php

declare(strict_types=1);

use App\Enum\DefaultTenantUserRole;
use App\Http\AppInertia;
use App\Http\Controllers\Tenant\CatController;
use App\Http\Controllers\Tenant\DogController;
use App\Http\Controllers\Tenant\MemberController;
use App\Http\Controllers\Tenant\OrganisationInvitationController;
use App\Http\Middleware\HasTenantRole;
use App\Http\Middleware\IsMember;
use App\Http\Middleware\IsTenantAdmin;
use App\Models\Tenant\Member;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
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
        return AppInertia::render('Welcome', [
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

    Route::middleware(['auth', 'verified', IsMember::class])->group(
        function () {
            Route::get('/dashboard', function () {
                Gate::authorize('viewAny', Member::class);
                $members = Member::with('roles')->get();
                return AppInertia::render('Tenant/Dashboard', [
                    'members' => $members,
                ]);
            })->name('tenant.dashboard');

            Route::middleware([IsTenantAdmin::class])->group(function () {
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

            Route::middleware([
                'tenantRole:admin,adoption-lead,adoption-handler',
            ])->group(function () {
                Route::name('animals.')
                    ->prefix('animals')
                    ->group(function () {
                        Route::resource('dogs', DogController::class);
                        Route::resource('cats', CatController::class);
                    });
            });
        },
    );
});
