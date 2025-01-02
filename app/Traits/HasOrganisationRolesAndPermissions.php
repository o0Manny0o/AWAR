<?php

namespace App\Traits;

use App\Authorisation\Enum\OrganisationRole;
use BackedEnum;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Laratrust\Traits\HasRolesAndPermissions;

trait HasOrganisationRolesAndPermissions
{
    use HasRolesAndPermissions;

    public function organisationRoles(): ?MorphToMany
    {
        return $this->rolesTeams();
    }

    public function organisationPermissions(): ?MorphToMany
    {
        return $this->permissionsTeams();
    }

    public function hasOrganisationRole(
        OrganisationRole $role,
        bool $requireAll = false,
    ): bool {
        if (!tenancy()->initialized) {
            return false;
        }
        return $this->hasRole($role->value, tenant(), $requireAll);
    }

    public function hasOrganisationPermission(
        string|array|BackedEnum $name,
        bool $requireAll = false,
    ): bool {
        if (!tenancy()->initialized) {
            return false;
        }
        return $this->hasPermission($name, tenant(), $requireAll);
    }

    public function addOrganisationRole(
        OrganisationRole $role,
        mixed $team = null,
    ): static {
        if (!$team && !tenancy()->initialized) {
            return $this;
        }
        return $this->addRole($role->value, $team ?? tenant());
    }

    public function removeOrganisationRole(
        OrganisationRole $role,
        mixed $team = null,
    ): static {
        if (!$team && !tenancy()->initialized) {
            return $this;
        }
        return $this->removeRole($role->value, $team ?? tenant());
    }

    public function addOrganisationRoles(
        array $roles,
        mixed $team = null,
    ): static {
        if (!$team && !tenancy()->initialized) {
            return $this;
        }

        $roles = array_map(
            function ($role) {
                return $role->value;
            },
            array_filter($roles, function ($role) {
                return $role instanceof OrganisationRole;
            }),
        );

        return $this->addRoles($roles, $team ?? tenant());
    }

    public function removeOrganisationRoles(
        array $roles,
        mixed $team = null,
    ): static {
        if (!$team && !tenancy()->initialized) {
            return $this;
        }

        $roles = array_map(
            function ($role) {
                return $role->value;
            },
            array_filter($roles, function ($role) {
                return $role instanceof OrganisationRole;
            }),
        );

        return $this->removeRoles($roles, $team ?? tenant());
    }
}
