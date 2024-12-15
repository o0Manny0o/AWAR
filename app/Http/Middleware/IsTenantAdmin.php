<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;

class IsTenantAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param string|null $redirectToRoute
     * @return Response|RedirectResponse|null
     */
    public function handle(
        Request $request,
        Closure $next,
        string $redirectToRoute = null,
    ) {
        if (tenant() && $request->user()?->member?->isAdmin()) {
            return $next($request);
        }
        return $request->expectsJson()
            ? abort(403, 'You are not allowed to access this page.')
            : Redirect::guest(
                URL::route(
                    $redirectToRoute ?:
                    (tenant()
                        ? 'tenant.dashboard'
                        : 'dashboard'),
                ),
            );
    }
}
