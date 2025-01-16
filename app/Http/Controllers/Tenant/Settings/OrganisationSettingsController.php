<?php

namespace App\Http\Controllers\Tenant\Settings;

use App\Http\AppInertia;
use App\Http\Controllers\Controller;
use App\Http\Requests\Organisation\Settings\UpdateFaviconRequest;
use App\Http\Requests\Organisation\Settings\UpdateLogoRequest;
use App\Http\Requests\Organisation\Settings\UpdateOrganisationSettingsRequest;
use App\Models\Tenant\OrganisationPublicSettings;
use Cloudinary\Api\Exception\ApiError;
use Illuminate\Auth\Access\AuthorizationException;

class OrganisationSettingsController extends Controller
{
    protected static string $baseViewPath = 'Tenant/Settings/PublicSettings';
    protected static string $baseRouteName = 'settings.public';

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

    /**
     * Show the form for editing the organisation favicon.
     * @throws AuthorizationException
     */
    public function editFavicon(): \Inertia\Response
    {
        /** @var OrganisationPublicSettings $settings */
        $settings = OrganisationPublicSettings::first();

        $this->authorize('update', $settings);

        return AppInertia::render($this->baseViewPath . '/Favicon/Edit', [
            'settings' => $settings,
        ]);
    }

    /**
     * Update the favicon of the organisation.
     * @throws AuthorizationException
     * @throws ApiError
     */
    public function updateFavicon(
        UpdateFaviconRequest $request,
    ): \Illuminate\Http\RedirectResponse {
        /** @var OrganisationPublicSettings $settings */
        $settings = OrganisationPublicSettings::first();

        $this->authorize('update', $settings);

        $validated = $request->validated();

        $uploadedFileUrl = cloudinary()
            ->upload($validated['favicon'], [
                'asset_folder' => tenant()->id,
                'public_id' => 'favicon',
                'public_id_prefix' => tenant()->id,
                'format' => 'png',
                'crop' => 'lfill',
                'width' => 192,
                'height' => 192,
            ])
            ->getSecurePath();

        $settings->favicon = $uploadedFileUrl;
        $settings->save();

        cache()->forget('tenant');
        return $this->redirect($request, $this->baseRouteName . '.show');
    }

    /**
     * Show the form for editing the organisation favicon.
     * @throws AuthorizationException
     */
    public function editLogo(): \Inertia\Response
    {
        /** @var OrganisationPublicSettings $settings */
        $settings = OrganisationPublicSettings::first();

        $this->authorize('update', $settings);

        return AppInertia::render($this->baseViewPath . '/Logo/Edit', [
            'settings' => $settings,
        ]);
    }

    /**
     * Update the favicon of the organisation.
     * @throws AuthorizationException
     * @throws ApiError
     */
    public function updateLogo(
        UpdateLogoRequest $request,
    ): \Illuminate\Http\RedirectResponse {
        /** @var OrganisationPublicSettings $settings */
        $settings = OrganisationPublicSettings::first();

        $this->authorize('update', $settings);

        $validated = $request->validated();

        $uploadedFileUrl = cloudinary()
            ->upload($validated['logo'], [
                'asset_folder' => tenant()->id,
                'public_id' => 'logo',
                'public_id_prefix' => tenant()->id,
                'format' => 'png',
                'crop' => 'lfill',
                'width' => 480,
            ])
            ->getSecurePath();

        $settings->logo = $uploadedFileUrl;
        $settings->save();

        cache()->forget('tenant');
        return $this->redirect($request, $this->baseRouteName . '.show');
    }
}
