<?php

namespace Database\Seeders;

use Database\Seeders\central\CentralRolesAndPermissionsSeeder;
use Database\Seeders\central\CountrySeeder;
use Illuminate\Database\Seeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CentralRolesAndPermissionsSeeder::class,
            CountrySeeder::class,
        ]);
    }
}
