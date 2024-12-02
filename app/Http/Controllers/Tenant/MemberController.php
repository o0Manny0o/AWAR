<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Tenant\Member;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use App\Http\AppInertia;
use Inertia\Response;

class MemberController extends Controller
{
    protected string $baseRouteName = 'organisation.members';
    protected string $baseViewPath = 'Tenant/Organisation/Member';

    /**
     * Display a listing of the resource.
     * @throws AuthorizationException
     */
    public function index(Request $request): Response
    {
        $this->authorize('viewAny', Member::class);

        $members = Member::with('roles')->get();

        return AppInertia::render($this->getIndexView(), [
            'members' => $members,
            'permissions' => $this->permissions($request),
        ]);
    }

    private function permissions(Request $request, Member $member = null): array
    {
        $member?->setPermissions($request->user());

        return [
            'organisations' => [
                'members' => [
                    'create' => $request->user()->can('create', Member::class),
                    'view' => $request->user()->can('view', $member),
                    'delete' => $request->user()->can('delete', $member),
                ],
            ],
        ];
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
