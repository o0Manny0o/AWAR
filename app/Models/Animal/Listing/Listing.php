<?php

namespace App\Models\Animal\Listing;

use App\Enum\ResourcePermission;
use App\Models\Animal\Animal;
use App\Traits\BelongsToOrganisation;
use App\Traits\HasResourcePermissions;
use CloudinaryLabs\CloudinaryLaravel\Model\Media;
use Database\Factories\Animal\Listing\ListingFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 *
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Animal\Animal> $animals
 * @property-read int|null $animals_count
 * @method static ListingFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Listing newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Listing newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Listing query()
 * @property string $id
 * @property string|null $description
 * @property string|null $excerpt
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Animal\Listing\ListingAnimal|null $pivot
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Listing whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Listing whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Listing whereExcerpt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Listing whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Listing whereUpdatedAt($value)
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Animal\Listing\ListingAnimal> $listingAnimals
 * @property-read int|null $listing_animals_count
 * @property-read mixed $images
 * @property-read mixed $media
 * @mixin \Eloquent
 */
class Listing extends Model
{
    /** @use HasFactory<ListingFactory> */
    use HasFactory, HasUuids, HasResourcePermissions, BelongsToOrganisation;

    protected $table = 'listings';

    protected $fillable = ['description', 'excerpt', 'organisation_id'];

    protected array $resource_permissions = [
        ResourcePermission::VIEW,
        ResourcePermission::DELETE,
        ResourcePermission::UPDATE,
    ];

    public function listingAnimals(): HasMany
    {
        return $this->hasMany(ListingAnimal::class, 'listing_id');
    }

    public function animals(): BelongsToMany
    {
        return $this->belongsToMany(
            Animal::class,
            'listing_animals',
            'listing_id',
            'animal_id',
        )
            ->withPivot(['id', 'listing_id', 'animal_id'])
            ->using(ListingAnimal::class);
    }

    public function getMediaAttribute()
    {
        return $this->listingAnimals
            ->map(function (ListingAnimal $listingAnimal) {
                return $listingAnimal
                    ->media()
                    ->get()
                    ->map(function (Media $media) {
                        return $media->id;
                    });
            })
            ->collapse();
    }
}
