<?php

namespace App\Http\Middleware;

use App\Enum\SelfDisclosure\SelfDisclosureStep;
use App\Models\Organisation;
use App\Services\SelfDisclosureService;
use Illuminate\Database\Eloquent\Builder;
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
                'isMember' =>
                    tenant() &&
                    $request
                        ->user()
                        ?->whereHas('tenants', function (Builder $query) {
                            $query->where('organisations.id', tenant('id'));
                        })
                        ->exists(),
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
            'tenants' => $request->user()
                ? global_cache()->remember(
                    'users:' . $request->user()->id . ':tenants',
                    18000,
                    function () use ($request) {
                        return Organisation::whereHas('members', function (
                            Builder $query,
                        ) use ($request) {
                            $query->where('users.id', $request->user()->id);
                        })
                            ->with('domains')
                            ->get();
                    },
                )
                : null,
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
