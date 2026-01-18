<?php

namespace Database\Seeders;

use App\Models\Organisation;
use Database\Seeders\Central\CentralRolesAndPermissionsSeeder;
use Database\Seeders\Central\CountrySeeder;
use Database\Seeders\Tenant\OrganisationRolesAndPermissionsSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Artisan::call('app:create-org', [
            'name' => 'public',
            'subdomain' => '',
        ]);

        $this->call([
            OrganisationRolesAndPermissionsSeeder::class,
            CentralRolesAndPermissionsSeeder::class,
            CountrySeeder::class,
        ]);
    }
}
