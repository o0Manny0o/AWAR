<?php

namespace App\Traits;

use CloudinaryLabs\CloudinaryLaravel\CloudinaryEngine;
use CloudinaryLabs\CloudinaryLaravel\MediaAlly as BaseMediaAlly;
use CloudinaryLabs\CloudinaryLaravel\Model\Media;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Http\UploadedFile;

trait MediaAlly
{
    use BaseMediaAlly {
        attachMedia as baseAttachMedia;
        medially as baseMedially;
    }

    /**
     * Relationship for all attached media.
     */
    public function medially(): MorphMany
    {
        return $this->morphMany(Media::class, 'medially')
            ->orderBy('order_column')
            ->orderBy('id');
    }

    /**
     * Attach Media Files to a Model
     * @throws Exception
     */
    public function attachMedia($file, $options = []): mixed
    {
        if (!$file instanceof UploadedFile) {
            throw new Exception('Please pass in a file that exists');
        }

        $response = resolve(CloudinaryEngine::class)->uploadFile(
            $file->getRealPath(),
            $options,
        );

        $media = new Media();
        $media->file_name = $response->getFileName();
        $media->file_url = $response->getSecurePath();
        $media->size = $response->getSize();
        $media->file_type = $response->getFileType();

        $m = $this->medially()->save($media);

        return $m->id;
    }

    /**
     * Get thumbnail of the model
     */
    protected function getThumbnailAttribute()
    {
        if ($this->medially?->first()) {
            return cloudinary()
                ->getImage($this->medially?->first()->file_name)
                ->namedTransformation('thumbnail')
                ->toUrl();
        }
        return null;
    }

    /**
     * Get small gallery images of the model
     */
    protected function getGalleryAttribute()
    {
        return $this->medially?->map(function ($image) {
            return cloudinary()
                ->getImage($image->file_name)
                ->namedTransformation('gallery')
                ->toUrl();
        });
    }

    /**
     * Get full size images of the model
     */
    protected function getImagesAttribute()
    {
        // TODO: Change the transformation
        return $this->medially?->map(function ($image) {
            return cloudinary()
                ->getImage($image->file_name)
                ->namedTransformation('gallery')
                ->toUrl();
        });
    }

    /**
     * Get the media of the model
     */
    protected function getMediaAttribute()
    {
        return $this->medially?->map(function ($image) {
            return [
                'id' => $image->id,
                'file_url' => cloudinary()
                    ->getImage($image->file_name)
                    ->namedTransformation('thumbnail')
                    ->toUrl(),
            ];
        });
    }
}
