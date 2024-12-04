<?php

namespace App\Http\Middleware;

use App\Models\Tenant\Member;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;

class HasTenantRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(
        Request $request,
        Closure $next,
        string $roles,
        string $redirectToRoute = null,
    ): Response {
        if (tenant() && $request->user()) {
            /** @var Member $member */
            $member = $request->user()->asMember();
            if ($member && $member->hasAnyRole($roles)) {
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
