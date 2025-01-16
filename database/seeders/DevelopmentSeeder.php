<?php

namespace Database\Seeders;

use App\Authorisation\Enum\CentralRole;
use App\Authorisation\Enum\OrganisationRole;
use App\Authorisation\PermissionContext;
use App\Models\Address;
use App\Models\Animal\Animal;
use App\Models\Animal\AnimalListing;
use App\Models\Animal\Cat;
use App\Models\Organisation;
use App\Models\Tenant\OrganisationLocation;
use App\Models\User;
use App\Services\AnimalService;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
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

        $user = User::factory()->developer()->create();

        Address::factory()->createOneQuietly([
            'addressable_id' => $user->id,
            'addressable_type' => User::class,
        ]);

        Artisan::call('app:create-org', [
            'name' => 'foo',
            'subdomain' => 'foo',
            'user_id' => $user->id,
        ]);

        Artisan::call('app:create-org', [
            'name' => 'bar',
            'subdomain' => 'bar',
        ]);

        $organisation = Organisation::whereName('foo')->first();

        PermissionContext::tenant(
            $user,
            function (User $user) {
                $user->assignRole(OrganisationRole::ADMIN);
            },
            $organisation,
        );

        PermissionContext::central($user, function (User $user) {
            $user->assignRole(CentralRole::ADMIN);
        });

        $this->createFooUsersAndMembers();
        $this->createBarUserAndMember();
        $this->createOrganisationLocation('foo');
        $this->createOrganisationLocation('bar');
        $this->createFooCat();
        $this->createbarCat();
    }

    private function createFooUsersAndMembers(): void
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

    private function createBarUserAndMember(): void
    {
        $user = User::factory()->create();

        Address::factory()->createQuietly([
            'addressable_id' => $user->id,
            'addressable_type' => User::class,
        ]);

        $organisation = Organisation::whereName('bar')->first();

        $user->tenants()->attach($organisation);

        setPermissionsTeamId($organisation);

        $user->assignRole(
            OrganisationRole::ADMIN,
            OrganisationRole::ANIMAL_LEAD,
            OrganisationRole::FOSTER_HOME_LEAD,
        );

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        setPermissionsTeamId(null);
    }

    private function createOrganisationLocation(string $name): void
    {
        $organisation = Organisation::whereName($name)->first();

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
    private function createFooCat(): void
    {
        $organisation = Organisation::whereName('foo')->first();

        /** @var Animal $animal */
        $animal = $organisation->run(function () use ($organisation) {
            $data = [
                'name' => 'Foo Cat',
                'breed' => 'British Shorthair',
                'date_of_birth' => '2020-01-01',
                'sex' => 'male',
                'bio' => 'Cat bio',
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
            return $this->animalService->createAnimal(
                $data,
                Cat::class,
                $organisation->members()->first(),
            );
        });

        AnimalListing::factory()
            ->hasAttached([$animal])
            ->create();
    }

    /**
     * @throws \Throwable
     * @throws FileNotFoundException
     */
    private function createBarCat(): void
    {
        $organisation = Organisation::whereName('bar')->first();

        /** @var Animal $animal */
        $animal = $organisation->run(function () use ($organisation) {
            $data = [
                'name' => 'Bar Cat',
                'breed' => 'British Shorthair',
                'date_of_birth' => '2020-01-01',
                'sex' => 'male',
                'bio' => 'Cat bio',
                'family' => null,
                'images' => [],
            ];
            Model::reguard();
            return $this->animalService->createAnimal(
                $data,
                Cat::class,
                $organisation->members()->first(),
            );
        });

        AnimalListing::factory()
            ->hasAttached([$animal])
            ->create();
    }
}
