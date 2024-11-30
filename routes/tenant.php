<?php

declare(strict_types=1);

use App\Http\Controllers\Tenant\OrganisationInvitationController;
use App\Models\Organisation;
use App\Models\User;
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


    Route::middleware(['auth', 'verified'])
        ->group(function () {
            Route::get('/dashboard', function () {
                return Inertia::render('Dashboard');
            })->name('tenant.dashboard');

            Route::get('/mailable', function () {
                $users = User::take(2)->get();
                /** @var Organisation $organisation */
                $organisation = Organisation::first();

                return new App\Mail\OrganisationInvitationMail($users->first(), $users->last(), $organisation, route("invitations.accept", "123"));
            });

            Route::name('organisation.')
                ->group(function () {

                    Route::name('invitations.')->prefix('invitations')->group(function () {
                        Route::get('/accept/{token}', [OrganisationInvitationController::class, 'accept'])->name("accept");
                    });

                    Route::resource('invitations', OrganisationInvitationController::class)
                        ->except(['edit', 'update']);
                });


        });
});
