<?php

namespace Database\Factories;

use App\Authorisation\Enum\OrganisationRole;
use App\Models\Organisation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => (static::$password ??= Hash::make('password')),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(
            fn(array $attributes) => [
                'email_verified_at' => null,
            ],
        );
    }

    public function developer(): static
    {
        return $this->state(
            fn(array $attributes) => [
                'name' => 'Moritz Wach',
                'email' => 'moritz.wach@gmail.com',
                'password' => Hash::make('ZGN7wth1rgw3nuv.rpd'),
            ],
        );
    }

    public function fosterHome(Organisation $organisation): static
    {
        return $this->state(
            fn(array $attributes) => [
                'email' => 'fosterhome@awar.app',
            ],
        )->afterCreating(function (User $user) use ($organisation) {
            setPermissionsTeamId($organisation);
            $user->assignRole(OrganisationRole::FOSTER_HOME);
            setPermissionsTeamId(null);
        });
    }

    public function admin(Organisation $organisation): static
    {
        return $this->state(
            fn(array $attributes) => [
                'email' => 'admin@awar.app',
            ],
        )->afterCreating(function (User $user) use ($organisation) {
            setPermissionsTeamId($organisation);
            $user->assignRole(OrganisationRole::ADMIN);
            setPermissionsTeamId(null);
        });
    }
}
