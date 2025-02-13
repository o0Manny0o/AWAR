<?php

namespace App\Models\Animal;

use App\Enum\ResourcePermission;
use App\Traits\HasResourcePermissions;
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
    use HasFactory, HasUuids, HasResourcePermissions;

    protected $table = 'listings';

    protected $fillable = ['description', 'excerpt'];

    protected array $resource_permissions = [
        ResourcePermission::VIEW,
        ResourcePermission::DELETE,
        ResourcePermission::UPDATE,
        ResourcePermission::PUBLISH,
    ];

    public function animals(): BelongsToMany
    {
        return $this->belongsToMany(
            Animal::class,
            'listing_animals',
            'listing_id',
            'animal_id',
        );
    }
}
