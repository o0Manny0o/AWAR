<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DevelopmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()
            ->count(3)
            ->create();

        $now = now();
        DB::table('organisations')->insert([
            "id" => 1,
            'name' => "foo",
            "created_at" => $now,
            "updated_at" => $now,
            "data" => "{\"name\": \"foo\", \"created_at\": \"$now\", \"updated_at\": \"$now\"}",
        ]);

        DB::table('domains')->insert([
            "id" => 1,
            "domain" => "foo." . config("tenancy.central_domains")[0],
            "subdomain" => "foo",
            "organisation_id" => 1,
            "created_at" => $now,
            "updated_at" => $now,
        ]);

        DB::table('organisation_user')->insert([
            "id" => 1,
            "user_id" => 1,
            "organisation_id" => 1,
            "created_at" => $now,
            "updated_at" => $now,
        ]);
    }
}
