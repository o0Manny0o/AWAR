<?php

namespace Database\Seeders\tenant;

use App\Enum\DefaultTenantUserRole;
use App\Enum\TenantPermission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TenantRolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * TODO: Research a way to use eloquent models like https://spatie.be/docs/laravel-permission/v6/advanced-usage/seeding
     * If you fail to install those migrations, you'll run into errors like Call to a member function perform() on null
     * when the cache store attempts to purge or update the cache. This package does strategic cache resets in various
     * places, so may trigger that error if your app's cache dependencies aren't set up.
     */
    public function run(): void
    {

        $now = now();
        $permissions = TenantPermission::values();

        $permissionIds = array_reduce($permissions, function ($result, $item) use ($now) {
            $id = DB::table('permissions')->insertGetId([
                'name' => $item,
                'guard_name' => 'web',
                "created_at" => $now,
                "updated_at" => $now,
            ]);
            $result[$item] = $id;
            return $result;
        }, array());

        $adoptionLeadId = $this->createRole(DefaultTenantUserRole::ADOPTION_LEAD);
        $adminId = $this->createRole(DefaultTenantUserRole::ADMIN);

        $this->addPermissionToRole($adminId, $permissionIds, DefaultTenantUserRole::ADMIN->permissions());
        $this->addPermissionToRole($adoptionLeadId, $permissionIds, DefaultTenantUserRole::ADOPTION_LEAD->permissions());


    }

    private function createRole($roleName): int
    {
        return DB::table('roles')->insertGetId([
            'name' => $roleName,
            'guard_name' => 'web',
            "created_at" => now(),
            "updated_at" => now()
        ]);
    }

    private function addPermissionToRole($roleId, $permissionIds, $permissionNames): void
    {
        $filteredPermissionIds = array_intersect_key($permissionIds, array_flip($permissionNames));
        DB::table('role_has_permissions')->insert(array_map(function ($id) use ($roleId) {
            return [
                'permission_id' => $id,
                'role_id' => $roleId,
            ];
        }, $filteredPermissionIds));
    }
}
