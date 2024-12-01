<?php

namespace App\Http\Requests\Organisation\Invitation;

class OrganisationInvitationRules
{
    public static function emailRules(): array
    {
        return [
            'required',
            'email',
            'max:255',
            'unique:App\Models\Tenant\OrganisationInvitation,email',
            'unique:App\Models\Tenant\Member,email'
        ];
    }

    public static function roleRules(): array
    {
        return [
            'required',
            'string',
            'exists:Spatie\Permission\Models\Role,id'
        ];
    }
}
