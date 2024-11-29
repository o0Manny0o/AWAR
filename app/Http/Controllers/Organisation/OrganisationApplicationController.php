<?php

namespace App\Http\Controllers\Organisation;

use App\Http\Controllers\Controller;
use App\Http\Requests\Organisation\Application\CreateOrganisationApplicationRequest;
use App\Http\Requests\Organisation\Application\UpdateOrganisationApplicationRequest;
use App\Models\OrganisationApplication;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class OrganisationApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     * @throws AuthorizationException
     */
    public function index(Request $request): Response
    {
        $this->authorize('viewAny', OrganisationApplication::class);
        $applications = OrganisationApplication::withTrashed()
            ->where('user_id', $request->user()->id)
            ->orderBy("deleted_at", "DESC")
            ->orderBy("updated_at", "DESC")
            ->get();
        return Inertia::render('Organisation/Application/Index', [
            'applications' => $applications,
            'permissions' => [
                'organisationApplications' => [
                    'create' => $request->user()->can('create', OrganisationApplication::class),
                ]
            ]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @throws AuthorizationException
     */
    public function create(Request $request): Response
    {
        $this->authorize('create', OrganisationApplication::class);
        return Inertia::render('Organisation/Application/Create', [
            'step' => 1
        ]);
    }

    /**
     * Show the form for creating a new resource at the provided step.
     * @throws AuthorizationException
     */
    public function createByStep(string $id, int $step): Response|RedirectResponse
    {
        $this->authorize('create', OrganisationApplication::class);

        $application = OrganisationApplication::withTrashed()->find($id);
        if (!$application || $step < 1 || $step > 3) {
            return redirect()->route('organisations.applications.create');
        }

        return Inertia::render('Organisation/Application/Create', [
            'step' => $step,
            'application' => $application
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @throws ValidationException
     * @throws AuthorizationException
     */
    public function store(CreateOrganisationApplicationRequest $request): RedirectResponse
    {
        $this->authorize('create', OrganisationApplication::class);
        $validated = $request->validated();

        $application = $request->user()->organisationApplications()->create($validated);

        return $this->redirect($request, 'organisations.applications.create.step', ['application' => $application, 'step' => 2]);
    }

    /**
     * Update the specified resource in storage.
     * @throws AuthorizationException
     */
    public function storeByStep(CreateOrganisationApplicationRequest $request, string $id, int $step): RedirectResponse
    {
        $application = OrganisationApplication::withTrashed()->find($id);
        if (!$application || $step < 1 || $step > 3) {
            return redirect()->route('organisations.applications.create');
        }
        $this->authorize('update', $application);
        $validated = $request->validated();

        if ($application->trashed()) {
            $application->restore();
            $application->update(["status" => "draft"]);
        }

        $application->update($validated);

        $updatedApplication = $application->refresh();

        return $this->redirect($request, 'organisations.applications.create.step', ['application' => $updatedApplication, 'step' => $step + 1]);

    }

    /**
     * Display the specified resource.
     * @throws AuthorizationException
     */
    public function show(string $id)
    {
        $application = OrganisationApplication::withTrashed()->find($id);
        if (!$application) {
            return redirect()->route('organisations.applications.index');
        }
        $this->authorize('view', $application);

        return Inertia::render('Organisation/Application/Show', [
            'application' => $application
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     * @throws AuthorizationException
     */
    public function edit(Request $request, string $id): Response|RedirectResponse
    {
        $application = OrganisationApplication::withTrashed()->find($id);
        if (!$application) {
            return redirect()->route('organisations.applications.index');
        }
        $this->authorize('update', $application);

        return Inertia::render('Organisation/Application/Edit', [
            'application' => $application
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @throws AuthorizationException
     */
    public function update(UpdateOrganisationApplicationRequest $request, string $id)
    {
        $application = OrganisationApplication::withTrashed()->find($id);
        if (!$application) {
            return redirect()->route('organisations.applications.index');
        }
        $this->authorize('update', $application);
        $validated = $request->validated();

        if ($application->trashed()) {
            $application->restore();
            $application->update(["status" => "draft"]);
        }

        $application->update($validated);

        return $this->redirect($request, 'organisations.applications.show', ['application' => $application]);

    }

    /**
     * Remove the specified resource from storage.
     * @throws AuthorizationException
     */
    public function destroy(Request $request, string $id)
    {
        $application = OrganisationApplication::find($id);
        if (!$application || $application->trashed()) {
            return redirect()->route('organisations.applications.index');
        }
        $this->authorize('delete', $application);

        $application->delete();

        return $this->redirect($request, 'organisations.applications.index');
    }

    /**
     * Restores the specified resource from storage.
     * @throws AuthorizationException
     */
    public function restore(Request $request, string $id)
    {
        $application = OrganisationApplication::withTrashed()->find($id);
        if (!$application || !$application->trashed()) {
            return redirect()->route('organisations.applications.index');
        }
        $this->authorize('restore', $application);

        $application->restore();

        $application->update(["status" => "draft"]);

        return $this->redirect($request, 'organisations.applications.index');
    }

    /**
     * Restores the specified resource from storage.
     * @throws AuthorizationException
     */
    public function submit(Request $request, string $id)
    {
        $application = OrganisationApplication::find($id);
        if (!$application) {
            return redirect()->route('organisations.applications.index');
        }
        $this->authorize('submit', $application);

        $application->update(["status" => "submitted"]);

        return $this->redirect($request, 'organisations.applications.show', ['application' => $application->id]);
    }
}
