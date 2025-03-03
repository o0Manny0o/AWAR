<?php

namespace App\Models\Animal\Listing;

use App\Models\Animal\Animal;
use CloudinaryLabs\CloudinaryLaravel\Model\Media;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 *
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Media> $media
 * @property-read int|null $media_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ListingAnimal newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ListingAnimal newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ListingAnimal query()
 * @property int $id
 * @property string $listing_id
 * @property string $animal_id
 * @property-read Animal $animal
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ListingAnimal whereAnimalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ListingAnimal whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ListingAnimal whereListingId($value)
 * @property-read \App\Models\Animal\Listing\Listing $listing
 * @mixin \Eloquent
 */
class ListingAnimal extends Pivot
{
    public $incrementing = true;

    protected $table = 'listing_animals';

    public function media(): BelongsToMany
    {
        return $this->belongsToMany(
            Media::class,
            'listing_media',
            'listing_animal_id',
            'media_id',
        );
    }

    public function listing(): BelongsTo
    {
        return $this->belongsTo(Listing::class);
    }

    public function animal(): BelongsTo
    {
        return $this->belongsTo(Animal::class);
    }
}
