<?php

namespace App\Http;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;
use Inertia\Response;

class AppInertia extends Inertia
{
    public static function render(
        string $component,
        array|Arrayable $props = [],
    ): Response {
        if (Session::has('messages')) {
            $shared = Inertia::getShared('messages', []);
            $messages = array_merge(Session::get('messages', []), $shared);
            AppInertia::share('messages', $messages);
        }
        return parent::render($component, $props);
    }
}
