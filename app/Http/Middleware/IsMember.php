<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;

class IsMember
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
            $member = $request->user()->asMember();
            if ($member) {
                return $next($request);
            }
        }
        return $request->expectsJson()
            ? abort(403, 'You are not allowed to access this page.')
            : Redirect::guest(
                URL::route(
                    $redirectToRoute ?:
                    (tenant()
                        ? 'tenant.landing-page'
                        : 'landing-page'),
                ),
            );
    }
}
