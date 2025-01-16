<?php

namespace App\Http\Middleware\SelfDisclosure;

use App\Enum\SelfDisclosure\SelfDisclosureStep;
use App\Services\SelfDisclosureService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PreventAccessToFutureSteps
{
    public function __construct(private readonly SelfDisclosureService $service)
    {
    }

    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(
        Request $request,
        Closure $next,
        string $step,
    ): Response {
        $disclosure = $this->service->getDisclosure($request->user());

        if ($disclosure->furthest_step) {
            $furthestStep = SelfDisclosureStep::from(
                $disclosure->furthest_step,
            );

            try {
                $attemptedStep = SelfDisclosureStep::from($step);
            } catch (\ValueError) {
                return redirect()->route($furthestStep->route());
            }

            if ($attemptedStep->index() > $furthestStep->index()) {
                return redirect()->route($furthestStep->route());
            }
        }

        return $next($request);
    }
}
