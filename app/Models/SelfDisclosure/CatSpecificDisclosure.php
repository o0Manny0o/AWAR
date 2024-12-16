<?php

namespace App\Models\SelfDisclosure;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 *
 *
 * @property-read \App\Models\SelfDisclosure\AnimalSpecificDisclosure|null $animalDisclosure
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CatSpecificDisclosure newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CatSpecificDisclosure newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CatSpecificDisclosure query()
 * @property int $id
 * @property string $habitat
 * @property bool|null $house_secure
 * @property string|null $sleeping_place
 * @property bool|null $streets_safe
 * @property bool|null $cat_flap_available
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CatSpecificDisclosure whereCatFlapAvailable($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CatSpecificDisclosure whereHabitat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CatSpecificDisclosure whereHouseSecure($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CatSpecificDisclosure whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CatSpecificDisclosure whereSleepingPlace($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CatSpecificDisclosure whereStreetsSafe($value)
 * @mixin \Eloquent
 */
class CatSpecificDisclosure extends Model
{
    public $timestamps = false;

    public function animalDisclosure(): MorphOne
    {
        return $this->morphOne(AnimalSpecificDisclosure::class, 'specifiable');
    }
}
