<?php

namespace App\Models\SelfDisclosure;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 *
 *
 * @property-read \App\Models\SelfDisclosure\UserAnimalSpecificDisclosure|null $animalDisclosure
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserCatSpecificDisclosure newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserCatSpecificDisclosure newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserCatSpecificDisclosure query()
 * @property int $id
 * @property string $habitat
 * @property bool|null $house_secure
 * @property string|null $sleeping_place
 * @property bool|null $streets_safe
 * @property bool|null $cat_flap_available
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserCatSpecificDisclosure whereCatFlapAvailable($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserCatSpecificDisclosure whereHabitat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserCatSpecificDisclosure whereHouseSecure($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserCatSpecificDisclosure whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserCatSpecificDisclosure whereSleepingPlace($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserCatSpecificDisclosure whereStreetsSafe($value)
 * @mixin \Eloquent
 */
class UserCatSpecificDisclosure extends Model
{
    public $timestamps = false;

    protected $guarded = ['id'];

    protected $hidden = ['id'];

    public function animalDisclosure(): MorphOne
    {
        return $this->morphOne(
            UserAnimalSpecificDisclosure::class,
            'specifiable',
        );
    }
}
