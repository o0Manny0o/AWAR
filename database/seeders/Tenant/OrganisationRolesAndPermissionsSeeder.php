<?php

namespace Database\Seeders\Tenant;

use App\Authorisation\Enum\OrganisationRole;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class OrganisationRolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $memberRole = Role::findOrCreate(OrganisationRole::MEMBER->value);
        $adminRole = Role::findOrCreate(OrganisationRole::ADMIN->value);
        $adoptionLeadRole = Role::findOrCreate(
            OrganisationRole::ANIMAL_LEAD->value,
        );
        $adoptionHandlerRole = Role::findOrCreate(
            OrganisationRole::ANIMAL_HANDLER->value,
        );
        $fosterHomeLeadRole = Role::findOrCreate(
            OrganisationRole::FOSTER_HOME_LEAD->value,
        );
        $fosterHomeHandlerRole = Role::findOrCreate(
            OrganisationRole::FOSTER_HOME_HANDLER->value,
        );
        $fosterHomeRole = Role::findOrCreate(
            OrganisationRole::FOSTER_HOME->value,
        );
    }
}
