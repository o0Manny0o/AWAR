<?php

namespace Database\Seeders\central;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @throws FileNotFoundException
     */
    public function run(): void
    {
        $json = File::json('database/data/countries.json');

        foreach ($json as $country) {
            \App\Models\Country::updateOrCreate(
                [
                    'alpha' => $country['alpha-2'],
                    'code' => $country['country-code'],
                ],
                [
                    'name' => $country['name'],
                ],
            );
        }
    }
}
