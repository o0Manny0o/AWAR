<?php

namespace Database\Seeders;

use App\Enum\CentralUserRole;
use App\Enum\DefaultTenantUserRole;
use App\Models\Animal\Animal;
use App\Models\Animal\Cat;
use App\Models\Organisation;
use App\Models\Tenant\Member;
use App\Models\User;
use App\Services\AnimalService;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\PermissionRegistrar;

class DevelopmentSeeder extends Seeder
{
    public function __construct(private readonly AnimalService $animalService)
    {
    }

    private function createUsersAndMembers()
    {
        $users = User::factory()->count(5)->create();

        $organisation = Organisation::first();

        foreach ($users as $u) {
            $u->tenants()->attach($organisation);
        }

        tenancy()
            ->find($organisation->id)
            ->run(function () use ($users) {
                Member::firstWhere(
                    'global_id',
                    $users[0]->global_id,
                )->assignRole(DefaultTenantUserRole::ADOPTION_LEAD);
                Member::firstWhere(
                    'global_id',
                    $users[1]->global_id,
                )->assignRole(DefaultTenantUserRole::ADOPTION_HANDLER);
                Member::firstWhere(
                    'global_id',
                    $users[2]->global_id,
                )->assignRole(DefaultTenantUserRole::FOSTER_HOME_LEAD);
                Member::firstWhere(
                    'global_id',
                    $users[3]->global_id,
                )->assignRole(DefaultTenantUserRole::FOSTER_HOME_HANDLER);
                Member::firstWhere(
                    'global_id',
                    $users[4]->global_id,
                )->assignRole(DefaultTenantUserRole::FOSTER_HOME);
            });

        app()[PermissionRegistrar::class]->forgetCachedPermissions();
    }

    /**
     * Run the database seeds.
     * @throws \Exception
     */
    public function run(): void
    {
        $this->call([DatabaseSeeder::class]);

        $user = User::factory()->create([
            'global_id' => Str::orderedUuid(),
            'name' => 'Moritz Wach',
            'email' => 'moritz.wach@gmail.com',
            'password' => Hash::make('ZGN7wth1rgw3nuv.rpd'),
        ]);

        Artisan::call('app:create-org', [
            'name' => 'foo',
            'subdomain' => 'foo',
            'user' => $user->id,
        ]);

        $user->assignRole(CentralUserRole::ADMIN);

        $this->createUsersAndMembers();
        $this->createCat($user);
    }

    /**
     * @throws \Throwable
     * @throws FileNotFoundException
     */
    private function createCat(User $user)
    {
        $organisation = Organisation::first();

        /** @var Animal $animal */
        $organisation->run(function () use ($user) {
            $data = [
                'name' => 'Cat',
                'breed' => 'British Shorthair',
                'date_of_birth' => '2020-01-01',
                'sex' => 'male',
                'bio' => 'Cat bio',
                'abstract' => 'Cat abstract',
                'family' => null,
                'images' => [
                    new UploadedFile(
                        base_path() .
                            '/database/data/9e8c8e83-34de-47bc-b293-33ea4c5fc27e.jpg',
                        'cat',
                        'image/jpeg',
                        null,
                        true,
                    ),
                ],
            ];
            Model::reguard();
            return $this->animalService->createAnimal($data, Cat::class, $user);
        });
    }
}
