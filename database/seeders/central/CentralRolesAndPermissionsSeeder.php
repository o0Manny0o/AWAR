<?php

namespace Database\Seeders\central;

use App\Enum\CentralUserRole;
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
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        Permission::create(['name' => 'edit articles']);
        Permission::create(['name' => 'delete articles']);
        Permission::create(['name' => 'publish articles']);
        Permission::create(['name' => 'unpublish articles']);


        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        Role::create(['name' => CentralUserRole::SUPER_ADMIN]);
        $adminRole = Role::create(['name' => CentralUserRole::ADMIN]);

        $adminRole->givePermissionTo(Permission::all());
    }
}
