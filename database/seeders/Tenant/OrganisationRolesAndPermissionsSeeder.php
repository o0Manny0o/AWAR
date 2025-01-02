<?php

namespace Database\Seeders\Tenant;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class OrganisationRolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @return void
     */
    public function run(): void
    {
        $config = Config::get('permission.role_structure');

        if ($config === null) {
            $this->command->error(
                'The role structure configuration not found.',
            );
            $this->command->line('');
            return;
        }

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        foreach ($config as $roleName => $modules) {
            // Create a new role
            $role = Role::firstOrCreate(['name' => $roleName]);
            $permissions = [];

            $this->command->info(
                'Creating Organisation Role ' . strtoupper($roleName),
            );

            // Reading role permission modules
            foreach ($modules as $module => $permissionList) {
                foreach ($permissionList as $permission) {
                    $permissions[] = Permission::firstOrCreate([
                        'name' => $permission->value . '-' . $module,
                    ])->id;

                    $this->command->info(
                        'Creating Permission to ' .
                            ucwords(str_replace('_', ' ', $permission->value)) .
                            ' ' .
                            ucwords(str_replace('_', ' ', $module)),
                    );
                }
            }

            app()[PermissionRegistrar::class]->forgetCachedPermissions();

            // Add all permissions to the role
            $role->permissions()->sync($permissions);
        }
    }
}
