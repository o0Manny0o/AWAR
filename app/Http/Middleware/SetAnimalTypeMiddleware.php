<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetAnimalTypeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(
        Request $request,
        Closure $next,
        string $animalModel,
    ): Response {
        $request->merge([
            'animal_model' => $animalModel,
        ]);
        return $next($request);
    }
}
