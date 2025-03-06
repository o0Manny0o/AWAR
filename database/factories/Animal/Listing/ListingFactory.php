<?php

namespace Database\Factories\Animal\Listing;

use App\Models\Organisation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Animal\Listing\Listing>
 */
class ListingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'description' => fake()->text(800),
            'excerpt' => fake()->text(),
            'organisation_id' => Organisation::whereName('foo')->first()->id,
        ];
    }

    public function forOrganisation(Organisation $organisation)
    {
        return $this->state(function (array $attributes) use ($organisation) {
            return [
                'organisation_id' => $organisation->id,
            ];
        });
    }
}
