<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;

/** TODO: Caching */
class IsMember
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
        /** @var User|null $user */
        $user = $request->user();
        if (
            tenant() &&
            $user
                ?->whereHas('tenants', function (Builder $query) {
                    $query->where('organisations.id', tenant('id'));
                })
                ->exists()
        ) {
            return $next($request);
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
