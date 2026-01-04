<?php

declare(strict_types=1);

use App\Http\AppInertia;
use App\Http\Controllers\Tenant\OrganisationInvitationController;
use App\Http\Middleware\IsMember;
use App\Models\Tenant\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

Route::middleware([
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    Route::get('/', function (Request $request) {
        return AppInertia::render('Welcome');
    })->name('tenant.landing-page');

    Route::get('invitations/accept/{token}', [
        OrganisationInvitationController::class,
        'accept',
    ])->name('organisation.invitations.accept');

    Route::middleware(['auth', 'verified', IsMember::class])
        ->prefix('/admin-old')
        ->group(function () {
            Route::get('/dashboard', function () {
                Gate::authorize('viewAny', Member::class);
                $members = tenant()->members()->with('roles')->get();
                return AppInertia::render('Tenant/Dashboard', [
                    'members' => $members,
                ]);
            })->name('tenant.dashboard');

            require __DIR__ . '/tenant/admin.php';
            require __DIR__ . '/tenant/animals.php';
        });
});
