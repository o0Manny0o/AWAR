<?php

namespace App\Models\Animal;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 *
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Animal\Animal> $animals
 * @property-read int|null $animals_count
 * @method static \Database\Factories\Animal\AnimalListingFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AnimalListing newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AnimalListing newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AnimalListing query()
 * @mixin \Eloquent
 */
class AnimalListing extends Model
{
    /** @use HasFactory<\Database\Factories\Animal\AnimalListingFactory> */
    use HasFactory, HasUuids;

    protected $table = 'listings';

    protected $fillable = ['description', 'excerpt'];

    public function animals(): BelongsToMany
    {
        return $this->belongsToMany(
            Animal::class,
            'listing_animal',
            'listing_id',
            'animal_id',
        );
    }
}
