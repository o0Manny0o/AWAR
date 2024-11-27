<?php

namespace Database\Seeders\tenant;

use App\Enum\TenantPermission;
use App\Enum\DefaultTenantUserRole;
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


        $adoptionLeadId = DB::table('roles')->insertGetId([
            'name' => DefaultTenantUserRole::ADOPTION_LEAD,
            'guard_name' => 'web',
            "created_at" => $now,
            "updated_at" => $now
        ]);

        $adminId = DB::table('roles')->insertGetId([
            'name' => DefaultTenantUserRole::ADMIN,
            'guard_name' => 'web',
            "created_at" => $now,
            "updated_at" => $now
        ]);

        $adminPermissionIds = array_intersect_key($permissionIds, array_flip(DefaultTenantUserRole::ADMIN->permissions()));
        $adoptionLeadPermissionIds = array_intersect_key($permissionIds, array_flip(DefaultTenantUserRole::ADOPTION_LEAD->permissions()));

        DB::table('role_has_permissions')->insert(array_map(function ($id) use ($adminId) {
            return [
                'permission_id' => $id,
                'role_id' => $adminId,
            ];
        }, $adminPermissionIds));

        DB::table('role_has_permissions')->insert(array_map(function ($id) use ($adoptionLeadId) {
            return [
                'permission_id' => $id,
                'role_id' => $adoptionLeadId,
            ];
        }, $adoptionLeadPermissionIds));


    }
}
