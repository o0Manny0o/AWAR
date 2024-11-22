<?php

namespace App\Http\Controllers\Organisation;

use App\Http\Controllers\Controller;
use App\Http\Requests\Organisation\CreateOrganisationApplicationRequest;
use App\Models\OrganisationApplication;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
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
            'applications' => $applications
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
     * Store a newly created resource in storage.
     * @throws ValidationException
     * @throws AuthorizationException
     */
    public function store(CreateOrganisationApplicationRequest $request)
    {
        $this->authorize('create', OrganisationApplication::class);
        $validated = $request->validated();

        $application = $request->user()->organisationApplications()->updateOrCreate([
            'name' => $validated['name'], 'user_id' => $request->user()->id
        ],
            [
                'id' => Str::orderedUuid(),
                'name' => $validated['name'],
                'type' => $validated['type'],
                'user_role' => $validated['user_role'],
                'registered' => $validated['registered']
            ]);

        return redirect()->route('organisations.applications.edit', ['application' => $application->id]);
    }

    /**
     * Display the specified resource.
     * @throws AuthorizationException
     */
    public function show(string $id)
    {
        $application = OrganisationApplication::withTrashed()->where("id", $id)->first();
        if (!$application) {
            return redirect()->route('organisations.applications.index');
        }
        $this->authorize('view', $application);
    }

    /**
     * Show the form for editing the specified resource.
     * @throws AuthorizationException
     */
    public function edit(Request $request, string $id): Response|RedirectResponse
    {
        $application = OrganisationApplication::withTrashed()->where("id", $id)->first();
        if (!$application) {
            return redirect()->route('organisations.applications.index');
        }
        $this->authorize('update', $application);

        $step = $request->input('step', $application->currentStep());

        return Inertia::render('Organisation/Application/Edit', [
            'step' => $step,
            'application' => $application
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @throws AuthorizationException
     */
    public function update(CreateOrganisationApplicationRequest $request, string $id)
    {
        $application = OrganisationApplication::withTrashed()->where("id", $id)->first();
        if (!$application) {
            return redirect()->route('organisations.applications.index');
        }
        $this->authorize('update', $application);
        $validated = $request->validated();

        $filteredData = Arr::except($validated, ['id', 'step']);

        if ($application->trashed()) {
            $application->restore();
            $application->update(["status" => "draft"]);
        }

        $application->update($filteredData);

        $updatedApplication = $application->refresh();

        if ($validated['step'] < 3) {
            return redirect()->route('organisations.applications.edit', ['application' => $updatedApplication->id, 'step' => $validated['step'] + 1,]);
        } else {
            return redirect()->route('organisations.applications.index');
        }

    }

    /**
     * Remove the specified resource from storage.
     * @throws AuthorizationException
     */
    public function destroy(string $id)
    {
        $application = OrganisationApplication::whereId($id)->first();
        if (!$application || $application->trashed()) {
            return redirect()->route('organisations.applications.index');
        }
        $this->authorize('delete', $application);

        $application->delete();

        return redirect()->route('organisations.applications.index');
    }

    /**
     * Restores the specified resource from storage.
     * @throws AuthorizationException
     */
    public function restore(string $id)
    {
        $application = OrganisationApplication::whereId($id)->first();
        if (!$application || !$application->trashed()) {
            return redirect()->route('organisations.applications.index');
        }
        $this->authorize('restore', $application);

        $application->restore();

        return redirect()->route('organisations.applications.index');
    }
}
