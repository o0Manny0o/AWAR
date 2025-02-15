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
}
