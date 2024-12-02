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
        if (Session::has('message')) {
            $messages = Inertia::getShared('messages', []);
            $messages[] = Session::get('message');
            AppInertia::share('messages', $messages);
        }
        return parent::render($component, $props);
    }
}
