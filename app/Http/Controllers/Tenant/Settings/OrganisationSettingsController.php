<?php

namespace App\Http\Controllers\Tenant\Settings;

use App\Http\AppInertia;
use App\Http\Controllers\Controller;
use App\Http\Requests\Organisation\Settings\UpdateOrganisationSettingsRequest;
use App\Models\Tenant\OrganisationPublicSettings;
use Illuminate\Auth\Access\AuthorizationException;

class OrganisationSettingsController extends Controller
{
    protected string $baseViewPath = 'Tenant/Settings/PublicSettings';
    protected string $baseRouteName = 'settings.public';
    /**
     * Display the specified resource.
     * @throws AuthorizationException
     */
    public function show(): \Inertia\Response
    {
        /** @var OrganisationPublicSettings $settings */
        $settings = OrganisationPublicSettings::first();

        $this->authorize('view', $settings);

        $settings->setPermissions(\Auth::user());

        return AppInertia::render($this->baseViewPath . '/Show', [
            'settings' => $settings,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     * @throws AuthorizationException
     */
    public function edit(): \Inertia\Response
    {
        /** @var OrganisationPublicSettings $settings */
        $settings = OrganisationPublicSettings::first();

        $this->authorize('update', $settings);

        return AppInertia::render($this->baseViewPath . '/Edit', [
            'settings' => $settings,
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @throws AuthorizationException
     */
    public function update(
        UpdateOrganisationSettingsRequest $request,
    ): \Illuminate\Http\RedirectResponse {
        /** @var OrganisationPublicSettings $settings */
        $settings = OrganisationPublicSettings::first();

        $this->authorize('update', $settings);

        $settings->update($request->validated());

        cache()->forget('tenant');

        return $this->redirect($request, $this->baseRouteName . '.show');
    }
}
