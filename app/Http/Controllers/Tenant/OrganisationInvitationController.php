<?php

namespace App\Http\Controllers\Tenant;

use App\Events\InvitationCreated;
use App\Http\Controllers\Controller;
use App\Http\Requests\Organisation\Invitation\CreateOrganisationInvitationRequest;
use App\Models\Tenant\OrganisationInvitation;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class OrganisationInvitationController extends Controller
{

    protected string $baseRouteName = "organisation.invitations";
    protected string $baseViewPath = "Tenant/Organisation/Invitation";

    private function permissions(Request $request, OrganisationInvitation $invitation = null): array
    {
        return [
            'organisations' => [
                'invitations' => [
                    'create' => $request->user()->can('create', OrganisationInvitation::class),
                    'view' => $request->user()->can('view', $invitation),
                    'delete' => $request->user()->can('delete', $invitation),
                ]
            ]
        ];
    }

    /**
     * Display a listing of the resource.
     * @throws AuthorizationException
     */
    public function index(Request $request): Response
    {
        $this->authorize('viewAny', OrganisationInvitation::class);

        $invitations = OrganisationInvitation::all();

        foreach ($invitations as $invitation) {
            $invitation->setPermissions($request->user());
        }

        return Inertia::render($this->getIndexView(), [
            'invitations' => $invitations,
            'permissions' => $this->permissions($request)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @throws AuthorizationException
     */
    public function create(): Response
    {
        $this->authorize('create', OrganisationInvitation::class);
        return Inertia::render($this->getCreateView());
    }

    /**
     * Store a newly created resource in storage.
     * @throws ValidationException
     * @throws AuthorizationException
     */
    public function store(CreateOrganisationInvitationRequest $request): RedirectResponse
    {
        $this->authorize('create', OrganisationInvitation::class);
        $validated = $request->validated();

        $invitation = $request->user()->asMember()->invitations()
            ->create(array_merge($validated, array('token' => Str::orderedUuid())));

        InvitationCreated::dispatch($invitation);

        return $this->redirect($request, $this->getShowRouteName(), ['invitation' => $invitation]);
    }

    /**
     * Display the specified resource.
     * @throws AuthorizationException
     */
    public function show(Request $request, string $id): Response|RedirectResponse
    {
        /** @var OrganisationInvitation $invitation */
        $invitation = OrganisationInvitation::find( $id);
        if (!$invitation) {
            return redirect()->route($this->getIndexRouteName());
        }
        $this->authorize('view', $invitation);

        return Inertia::render($this->getShowView(), [
            'invitation' => $invitation,
            'permissions' => $this->permissions($request, $invitation)
        ]);
    }

    /**
     * Resend the specified resource.
     * @throws AuthorizationException
     */
    public function resend(Request $request, string $id): Response|RedirectResponse
    {
        /** @var OrganisationInvitation $invitation */
        $invitation = OrganisationInvitation::find( $id);
        if (!$invitation) {
            return redirect()->route($this->getIndexRouteName());
        }

        $this->authorize('resend', $invitation);

        $invitation->update([
            'sent_at' => null,
            'status' => 'pending'
        ]);

        InvitationCreated::dispatch($invitation);

        return $this->redirect($request, $this->getIndexRouteName());
    }
}
