<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;

class DevelopmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            DatabaseSeeder::class
        ]);

        User::factory()
            ->count(3)
            ->create();

        $user = User::factory()->create([
            'name' => "Moritz Wach",
            'email' => 'moritz.wach@gmail.com',
            'password' => Hash::make('ZGN7wth1rgw3nuv.rpd')
        ]);

        Artisan::call('app:create-org', [
            'name' => 'foo', 'subdomain' => 'foo', 'user' => $user->id
        ]);

    }
}
