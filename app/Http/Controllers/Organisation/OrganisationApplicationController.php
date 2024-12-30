<?php

namespace App\Http\Controllers\Organisation;

use App\Http\AppInertia;
use App\Http\Controllers\Controller;
use App\Http\Requests\Organisation\Application\CreateOrganisationApplicationRequest;
use App\Http\Requests\Organisation\Application\UpdateOrganisationApplicationRequest;
use App\Models\OrganisationApplication;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
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
            ->orderBy('deleted_at', 'DESC')
            ->orderBy('updated_at', 'DESC')
            ->get();

        foreach ($applications as $application) {
            $application->setPermissions($request->user());
        }

        return AppInertia::render('Settings/Application/Index', [
            'applications' => $applications,
            'canCreate' => $request
                ->user()
                ->can('create', OrganisationApplication::class),
        ]);
    }

    /**
     * Show the form for creating a new resource at the provided step.
     * @throws AuthorizationException
     */
    public function createByStep(
        string $id,
        int $step,
    ): Response|RedirectResponse {
        $this->authorize('create', OrganisationApplication::class);

        $application = OrganisationApplication::withTrashed()->find($id);
        if (!$application || $step < 1 || $step > 3) {
            return redirect()->route('settings.applications.create');
        }

        return AppInertia::render('Settings/Application/Create', [
            'step' => $step,
            'application' => $application,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @throws ValidationException
     * @throws AuthorizationException
     */
    public function store(
        CreateOrganisationApplicationRequest $request,
    ): RedirectResponse {
        $this->authorize('create', OrganisationApplication::class);
        $validated = $request->validated();

        $application = $request
            ->user()
            ->organisationApplications()
            ->create($validated);

        return $this->redirect($request, 'settings.applications.create.step', [
            'application' => $application,
            'step' => 2,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @throws AuthorizationException
     */
    public function create(Request $request): Response
    {
        $this->authorize('create', OrganisationApplication::class);
        return AppInertia::render('Settings/Application/Create', [
            'step' => 1,
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @throws AuthorizationException
     */
    public function storeByStep(
        CreateOrganisationApplicationRequest $request,
        string $id,
        int $step,
    ): RedirectResponse {
        $application = OrganisationApplication::withTrashed()->find($id);
        if (!$application || $step < 1 || $step > 3) {
            return redirect()->route('settings.applications.create');
        }
        $this->authorize('update', $application);
        $validated = $request->validated();

        if ($application->trashed()) {
            $application->restore();
            $application->update(['status' => 'draft']);
        }

        $application->update($validated);

        $updatedApplication = $application->refresh();

        if ($step === 3) {
            return $this->redirect($request, 'settings.applications.show', [
                'application' => $updatedApplication,
            ]);
        }

        return $this->redirect($request, 'settings.applications.create.step', [
            'application' => $updatedApplication,
            'step' => $step + 1,
        ]);
    }

    /**
     * Restores the specified resource from storage.
     * @throws AuthorizationException
     */
    public function restore(Request $request, string $id)
    {
        $application = OrganisationApplication::withTrashed()->find($id);
        if (!$application || !$application->trashed()) {
            return redirect()->route('settings.applications.index');
        }
        $this->authorize('restore', $application);

        $application->restore();

        $application->update(['status' => 'draft']);

        return $this->redirect($request, 'settings.applications.index');
    }

    /**
     * Update the specified resource in storage.
     * @throws AuthorizationException
     */
    public function update(
        UpdateOrganisationApplicationRequest $request,
        string $id,
    ) {
        $application = OrganisationApplication::withTrashed()->find($id);
        if (!$application) {
            return redirect()->route('settings.applications.index');
        }
        $this->authorize('update', $application);
        $validated = $request->validated();

        if ($application->trashed()) {
            $application->restore();
            $application->update(['status' => 'draft']);
        }

        $application->update($validated);

        return $this->redirect($request, 'settings.applications.show', [
            'application' => $application,
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
        $application = OrganisationApplication::withTrashed()->find($id);
        if (!$application) {
            return redirect()->route('settings.applications.index');
        }
        $this->authorize('view', $application);

        $application->setPermissions($request->user());

        return AppInertia::render('Settings/Application/Show', [
            'application' => $application,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     * @throws AuthorizationException
     */
    public function edit(
        Request $request,
        string $id,
    ): Response|RedirectResponse {
        $application = OrganisationApplication::withTrashed()->find($id);
        if (!$application) {
            return redirect()->route('settings.applications.index');
        }
        $this->authorize('update', $application);

        return AppInertia::render('Settings/Application/Edit', [
            'application' => $application,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     * @throws AuthorizationException
     */
    public function destroy(Request $request, string $id)
    {
        $application = OrganisationApplication::find($id);
        if (!$application || $application->trashed()) {
            return redirect()->route('settings.applications.index');
        }
        $this->authorize('delete', $application);

        $application->delete();

        return $this->redirect($request, 'settings.applications.index');
    }

    /**
     * Restores the specified resource from storage.
     * @throws AuthorizationException
     */
    public function submit(Request $request, string $id)
    {
        $application = OrganisationApplication::find($id);
        if (!$application) {
            return redirect()->route('settings.applications.index');
        }
        $this->authorize('submit', $application);

        $application->update(['status' => 'submitted']);

        return $this->redirect($request, 'settings.applications.show', [
            'application' => $application->id,
        ]);
    }
}
