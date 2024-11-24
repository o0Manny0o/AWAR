<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

abstract class Controller
{
    use AuthorizesRequests;

    protected function redirect(Request $request, string $route, mixed $parameters = []): RedirectResponse
    {
        $redirect = $request->input('redirect');

        if ($redirect) {
            return redirect($redirect);
        }

        return redirect()->route($route, $parameters);
    }
}
