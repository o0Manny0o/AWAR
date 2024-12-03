<?php

namespace App\Http\Middleware;

use App\Models\Tenant\Member;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;

class IsTenantAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param string|null $redirectToRoute
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse|null
     */
    public function handle(
        Request $request,
        Closure $next,
        string $redirectToRoute = null,
    ) {
        if (tenant() && $request->user()) {
            /** @var Member $member */
            $member = $request->user()->asMember();
            if ($member && $member->isAdmin()) {
                return $next($request);
            }
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
