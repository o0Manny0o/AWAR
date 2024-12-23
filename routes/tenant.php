<?php

declare(strict_types=1);

use App\Http\AppInertia;
use App\Http\Controllers\Tenant\OrganisationInvitationController;
use App\Http\Middleware\IsMember;
use App\Models\Tenant\Member;
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
        return AppInertia::render('Welcome');
    })->name('tenant.landing-page');

    Route::get('invitations/accept/{token}', [
        OrganisationInvitationController::class,
        'accept',
    ])->name('organisation.invitations.accept');

    Route::middleware(['auth', 'verified', IsMember::class])->group(
        function () {
            Route::get('/dashboard', function () {
                Gate::authorize('viewAny', Member::class);
                $members = tenant()->members()->with('roles')->get();
                return AppInertia::render('Tenant/Dashboard', [
                    'members' => $members,
                ]);
            })->name('tenant.dashboard');

            require __DIR__ . '/tenant/admin.php';
            require __DIR__ . '/tenant/animals.php';
        },
    );
});
