<?php

namespace Database\Seeders;

use App\Authorisation\Enum\CentralRole;
use App\Authorisation\Enum\OrganisationRole;
use App\Models\Address;
use App\Models\Animal\Animal;
use App\Models\Animal\Cat;
use App\Models\Organisation;
use App\Models\Tenant\OrganisationLocation;
use App\Models\User;
use App\Services\AnimalService;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\PermissionRegistrar;

class DevelopmentSeeder extends Seeder
{
    public function __construct(private readonly AnimalService $animalService)
    {
    }

    /**
     * Run the database seeds.
     * @throws \Exception
     */
    public function run(): void
    {
        $this->call([DatabaseSeeder::class]);

        $user = User::factory()->create([
            'name' => 'Moritz Wach',
            'email' => 'moritz.wach@gmail.com',
        ]);

        Address::factory()->createOneQuietly([
            'addressable_id' => $user->id,
            'addressable_type' => User::class,
        ]);

        Artisan::call('app:create-org', [
            'name' => 'foo',
            'subdomain' => 'foo',
            'user_id' => $user->id,
        ]);

        $organisation = Organisation::whereName('foo')->first();
        setPermissionsTeamId($organisation);
        $user->assignRole(OrganisationRole::ADMIN);

        $public = Organisation::whereName('public')->first();
        setPermissionsTeamId($public);
        $user->assignRole(CentralRole::ADMIN);
        setPermissionsTeamId(null);

        $this->createUsersAndMembers();
        $this->createOrganisationLocation();
        $this->createCat($user);
    }

    private function createUsersAndMembers()
    {
        $users = User::factory()->count(5)->create();

        Address::factory()->createManyQuietly(
            $users->map(function (User $u) {
                return [
                    'addressable_id' => $u->id,
                    'addressable_type' => User::class,
                ];
            }),
        );

        $organisation = Organisation::whereName('foo')->first();

        foreach ($users as $u) {
            $u->tenants()->attach($organisation);
        }

        setPermissionsTeamId($organisation);

        User::find($users[0]->id)->assignRole(OrganisationRole::ANIMAL_LEAD);
        User::find($users[1]->id)->assignRole(OrganisationRole::ANIMAL_HANDLER);
        User::find($users[2]->id)->assignRole(
            OrganisationRole::FOSTER_HOME_LEAD,
        );
        User::find($users[3]->id)->assignRole(
            OrganisationRole::FOSTER_HOME_HANDLER,
        );
        User::find($users[4]->id)->assignRole(OrganisationRole::FOSTER_HOME);

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        setPermissionsTeamId(null);
    }

    private function createOrganisationLocation()
    {
        $organisation = Organisation::first();

        $location = OrganisationLocation::factory()->createOne([
            'organisation_id' => $organisation->id,
        ]);

        Address::factory()->createOneQuietly([
            'addressable_id' => $location->id,
            'addressable_type' => OrganisationLocation::class,
        ]);
    }

    /**
     * @throws \Throwable
     * @throws FileNotFoundException
     */
    private function createCat(User $user)
    {
        $organisation = Organisation::whereName('foo')->first();

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
                    //                    new UploadedFile(
                    //                        base_path() .
                    //                            '/database/data/9e8c8e83-34de-47bc-b293-33ea4c5fc27e.jpg',
                    //                        'cat',
                    //                        'image/jpeg',
                    //                        null,
                    //                        true,
                    //                    ),
                ],
            ];
            Model::reguard();
            return $this->animalService->createAnimal($data, Cat::class, $user);
        });
    }
}
