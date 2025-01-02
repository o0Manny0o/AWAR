<?php

namespace App\Http\Middleware;

use App\Enum\SelfDisclosure\SelfDisclosureStep;
use App\Services\SelfDisclosureService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Inertia\Middleware;
use Tighten\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    public function __construct(
        private readonly SelfDisclosureService $disclosureService,
    ) {
    }

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user(),
                'isMember' => $request->user()?->isMember(),
            ],
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'ziggy' => fn() => [
                ...(new Ziggy())->toArray(),
                'location' => $request->url(),
            ],
            'locale' => App::currentLocale(),
            'locales' => config('app.available_locales'),
            'centralDomain' => config('tenancy.central_domains')[0],
            'previousUrl' => function () {
                if (
                    url()->previous() !== route('login') &&
                    url()->previous() !== '' &&
                    url()->previous() !== url()->current()
                ) {
                    return url()->previous();
                } else {
                    return null;
                }
            },
            'tenants' => $request->user()?->cachedTenants(),
            'tenant' => tenancy()->initialized
                ? cache()->remember('tenant', 18000, function () {
                    $tenant = tenancy()->tenant;
                    $tenant?->load(['domains', 'publicSettings']);
                    return $tenant;
                })
                : null,
            'nextSteps' => [
                ...!tenancy()->initialized &&
                \Auth::check() &&
                $this->disclosureService->getDisclosure()->furthest_step !==
                    SelfDisclosureStep::COMPLETE->value
                    ? ['selfDisclosure']
                    : [],
            ],
        ];
    }
}
