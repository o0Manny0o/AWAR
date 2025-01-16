<?php

namespace Database\Seeders\Central;

use App\Authorisation\Enum\CentralRole;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;
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
        $config = Config::get('permission.central_role_structure');

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
            $role = Role::firstOrCreate([
                'name' => $roleName,
                'central' => true,
            ]);
            $permissions = [];

            $this->command->info(
                'Creating Central Role ' . strtoupper($roleName),
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

        $this->command->info(
            'Creating Central Role ' .
                strtoupper(CentralRole::SUPER_ADMIN->value) .
                ' with all permissions',
        );

        $superAdmin = Role::firstOrCreate([
            'name' => CentralRole::SUPER_ADMIN->value,
            'central' => true,
        ]);
        $superAdmin->givePermissionTo(Permission::all());
    }
}
