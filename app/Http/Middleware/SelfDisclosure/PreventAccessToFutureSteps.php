<?php

namespace App\Http\Middleware\SelfDisclosure;

use App\Enum\SelfDisclosure\SelfDisclosureStep;
use App\Models\SelfDisclosure\UserSelfDisclosure;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PreventAccessToFutureSteps
{
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
        $disclosure = UserSelfDisclosure::where(
            'global_user_id',
            $request->user()->global_id,
        )->first();

        if ($disclosure && $disclosure->furthest_step) {
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
