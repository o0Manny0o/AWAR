<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Sets App locale from session.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()) {
            Session()->put('locale', $request->user()->preferredLocale());
        }
        if ($request->session()->has('locale')) {
            App::setLocale(
                $request->session()->get('locale', config('app.locale')),
            );
        }
        return $next($request);
    }
}
