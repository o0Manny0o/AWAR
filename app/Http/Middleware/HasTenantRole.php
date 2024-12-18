<?php

namespace App\Http\Middleware;

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
     * @param Request $request
     * @param Closure(Request): (Response) $next
     * @param array $roles
     * @return Response
     */
    public function handle(
        Request $request,
        Closure $next,
        string ...$roles,
    ): Response {
        if (tenant() && $request->user()?->member?->hasAnyRole($roles)) {
            return $next($request);
        }
        return $request->expectsJson()
            ? abort(403, 'You are not allowed to access this page.')
            : Redirect::guest(
                URL::route(tenant() ? 'tenant.dashboard' : 'dashboard'),
            );
    }
}
