<?php

namespace App\Http\Controllers\Tenant;

use App\Events\InvitationAccepted;
use App\Events\InvitationSaved;
use App\Http\AppInertia;
use App\Http\Controllers\Controller;
use App\Http\Requests\Organisation\Invitation\CreateOrganisationInvitationRequest;
use App\Messages\ToastMessage;
use App\Models\Tenant\OrganisationInvitation;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Inertia\Response;
use Spatie\Permission\Models\Role;

class OrganisationInvitationController extends Controller
{
    protected string $baseRouteName = 'organisation.invitations';
    protected string $baseViewPath = 'Tenant/Organisation/Invitation';

    /**
     * Display a listing of the resource.
     * @throws AuthorizationException
     */
    public function index(Request $request): Response
    {
        $this->authorize('viewAny', OrganisationInvitation::class);

        $invitations = OrganisationInvitation::with('role')->get();

        foreach ($invitations as $invitation) {
            $invitation->setPermissions($request->user());
        }

        return AppInertia::render($this->getIndexView(), [
            'invitations' => $invitations,
            'permissions' => $this->permissions($request),
        ]);
    }

    private function permissions(
        Request $request,
        OrganisationInvitation $invitation = null,
    ): array {
        $invitation?->setPermissions($request->user());

        return [
            'organisations' => [
                'invitations' => [
                    'create' => $request
                        ->user()
                        ->can('create', OrganisationInvitation::class),
                    'view' => $request->user()->can('view', $invitation),
                    'delete' => $request->user()->can('delete', $invitation),
                ],
            ],
        ];
    }

    /**
     * Store a newly created resource in storage.
     * @throws ValidationException
     * @throws AuthorizationException
     */
    public function store(
        CreateOrganisationInvitationRequest $request,
    ): RedirectResponse {
        $this->authorize('create', OrganisationInvitation::class);
        $validated = $request->validated();

        $invitation = $request
            ->user()
            ->asMember()
            ->invitations()
            ->create(
                array_merge($validated, [
                    'token' => Str::orderedUuid(),
                ]),
            );

        InvitationSaved::dispatch($invitation);

        return $this->redirect($request, $this->getShowRouteName(), [
            'invitation' => $invitation,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @throws AuthorizationException
     */
    public function create(): Response
    {
        $this->authorize('create', OrganisationInvitation::class);
        $roles = Role::all()->pluck('name', 'id')->toArray();
        return AppInertia::render($this->getCreateView(), [
            'roleOptions' => $roles,
        ]);
    }

    /**
     * Display the specified resource.
     * @throws AuthorizationException
     */
    public function show(
        Request $request,
        string $id,
    ): Response|RedirectResponse {
        /** @var OrganisationInvitation $invitation */
        $invitation = OrganisationInvitation::with('role')->find($id);
        if (!$invitation) {
            return redirect()->route($this->getIndexRouteName());
        }
        $this->authorize('view', $invitation);

        return AppInertia::render($this->getShowView(), [
            'invitation' => $invitation,
            'permissions' => $this->permissions($request, $invitation),
        ]);
    }

    /**
     * Resend the specified resource.
     * @throws AuthorizationException
     */
    public function resend(
        Request $request,
        string $id,
    ): Response|RedirectResponse {
        /** @var OrganisationInvitation $invitation */
        $invitation = OrganisationInvitation::find($id);
        if (!$invitation) {
            return redirect()->route($this->getIndexRouteName());
        }

        $this->authorize('resend', $invitation);

        $invitation->update([
            'sent_at' => null,
            'status' => 'pending',
        ]);

        InvitationSaved::dispatch($invitation);

        return $this->redirect($request, $this->getIndexRouteName());
    }

    /**
     * Resend the specified resource.
     * @throws AuthorizationException
     */
    public function accept(
        Request $request,
        string $token,
    ): Response|RedirectResponse {
        /** @var OrganisationInvitation $invitation */
        $invitation = OrganisationInvitation::firstWhere('token', $token);
        if (!$invitation || $invitation->isExpired()) {
            ToastMessage::warning(
                __('organisations.invitations.messages.expired'),
            );
            return redirect()->route('tenant.landing-page');
        }

        if ($request->user()) {
            if ($request->user()->email === $invitation->email) {
                if (
                    $request
                        ->user()
                        ->tenants()
                        ->where('tenant_id', tenancy()->tenant->id)
                        ->exists()
                ) {
                    // User already accepted the invitation
                    ToastMessage::warning(
                        __(
                            'organisations.invitations.messages.already_accepted',
                        ),
                    );
                    return redirect()->route('tenant.landing-page');
                }
                $request
                    ->user()
                    ->tenants()
                    ->attach(tenancy()->tenant);
                ToastMessage::success(
                    __('organisations.invitations.messages.accepted', [
                        'organisation' => tenancy()->tenant->name,
                    ]),
                );
                event(
                    new InvitationAccepted(
                        $request->token,
                        tenancy()->tenant->id,
                        $request->user(),
                    ),
                );
            } else {
                ToastMessage::warning(
                    __('organisations.invitations.messages.wrong_email'),
                );
            }
            return redirect()->route('tenant.landing-page');
        } else {
            $user = User::firstWhere('email', $invitation->email);

            return redirect()->route($user ? 'login' : 'register', [
                'token' => $invitation->token,
                'organisation' => tenancy()->tenant->id,
            ]);
        }
    }
}
