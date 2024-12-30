<?php

namespace App\Http\Controllers\Tenant;

use App\Http\AppInertia;
use App\Http\Controllers\Controller;
use App\Models\Tenant\Member;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Inertia\Response;

class MemberController extends Controller
{
    protected string $baseRouteName = 'organisation.members';
    protected string $baseViewPath = 'Tenant/Settings/Member';

    /**
     * Display a listing of the resource.
     * @throws AuthorizationException
     */
    public function index(Request $request): Response
    {
        $this->authorize('viewAny', Member::class);

        $members = tenant()->members()->with('roles')->get();

        return AppInertia::render($this->getIndexView(), [
            'members' => $members,
            'canCreate' => $request->user()->can('create', Member::class),
        ]);
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
