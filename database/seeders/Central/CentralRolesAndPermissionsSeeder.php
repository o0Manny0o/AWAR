<?php

namespace Database\Seeders\Central;

use App\Authorisation\Enum\CentralRole;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class CentralRolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Permission::create(['name' => 'edit articles']);

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $superAdminRole = Role::findOrCreate(CentralRole::SUPER_ADMIN->value);
        $adminRole = Role::findOrCreate(CentralRole::ADMIN->value);

        $adminRole->givePermissionTo(Permission::all());
    }
}
