<?php

namespace App\Models\Animal\Listing;

use CloudinaryLabs\CloudinaryLaravel\Model\Media;
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
}
