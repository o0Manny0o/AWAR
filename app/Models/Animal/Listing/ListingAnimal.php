<?php

namespace App\Models\Animal\Listing;

use CloudinaryLabs\CloudinaryLaravel\Model\Media;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ListingAnimal extends Pivot
{
    public $incrementing = true;

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
