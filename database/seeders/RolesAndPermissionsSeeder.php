<?php

namespace Database\Seeders;

use App\Enum\CentralUserRole;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $role = Role::create(['name' => CentralUserRole::SUPER_ADMIN]);
        $role = Role::create(['name' => CentralUserRole::ADMIN]);
        $role->givePermissionTo(Permission::all());
    }
}
