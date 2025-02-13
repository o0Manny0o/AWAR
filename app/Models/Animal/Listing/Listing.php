<?php

namespace App\Models\Animal\Listing;

use App\Enum\ResourcePermission;
use App\Models\Animal\Animal;
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
 * @method static \Database\Factories\Animal\ListingFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Listing newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Listing newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Listing query()
 * @mixin \Eloquent
 */
class Listing extends Model
{
    /** @use HasFactory<\Database\Factories\Animal\ListingFactory> */
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
        )->using(ListingAnimal::class);
    }
}
