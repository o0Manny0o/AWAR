<?php

namespace Database\Seeders;

use Database\Seeders\Tenant\OrganisationRolesAndPermissionsSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TenantSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([OrganisationRolesAndPermissionsSeeder::class]);
    }
}
