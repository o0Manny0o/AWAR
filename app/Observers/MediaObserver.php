<?php

namespace App\Observers;

use CloudinaryLabs\CloudinaryLaravel\Model\Media;

class MediaObserver
{
    /**
     * Handle the Media "created" event.
     */
    public function creating(Media $media): void
    {
        if (is_null($media->order_column)) {
            $media->order_column =
                (int) Media::where('medially_type', $media->medially_type)
                    ->where('medially_id', $media->medially_id)
                    ->max('order_column') + 1;
        }
    }
}
