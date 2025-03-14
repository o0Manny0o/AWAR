<?php

namespace App\Services;

use CloudinaryLabs\CloudinaryLaravel\Model\Media;
use Exception;

class MediaService
{
    /**
     * @throws Exception
     */
    public function attachMedia($model, array $media, $organisation): array
    {
        $newIds = [];
        foreach ($media as $image) {
            $newIds[] = $model->attachMedia($image, [
                'asset_folder' => $organisation->id . '/animals/' . $model->id,
                'public_id_prefix' => $organisation->id,
                'width' => 2000,
                'crop' => 'limit',
                'format' => 'webp',
            ]);
        }
        return $newIds;
    }

    public static function setMediaOrder(array $ids, int $startOrder = 1): void
    {
        foreach ($ids as $id) {
            if (is_numeric($id)) {
                $model = Media::find($id);
            } else {
                $model = Media::where('id', $id)->first();
            }
            if (!$model) {
                continue;
            }

            $model->order_column = $startOrder++;

            $model->save();
        }
    }
}
