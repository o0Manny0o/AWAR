<?php

namespace App\Services;

use CloudinaryLabs\CloudinaryLaravel\Model\Media;
use Exception;

class MediaService
{
    /**
     * @throws Exception
     */
    public function attachMedia($model, array $media, $organisation): void
    {
        foreach ($media as $image) {
            $model->attachMedia($image, [
                'asset_folder' => $organisation->id . '/animals/' . $model->id,
                'public_id_prefix' => $organisation->id,
                'width' => 2000,
                'crop' => 'limit',
                'format' => 'webp',
            ]);
        }
    }

    public static function setMediaOrder(array $ids, int $startOrder = 1): void
    {
        foreach ($ids as $id) {
            $model = Media::find($id);
            if (!$model) {
                continue;
            }

            $model->order_column = $startOrder++;

            $model->save();
        }
    }
}
