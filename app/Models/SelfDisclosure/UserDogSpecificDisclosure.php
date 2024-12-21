<?php

namespace App\Models\SelfDisclosure;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 *
 *
 * @property-read \App\Models\SelfDisclosure\UserAnimalSpecificDisclosure|null $animalDisclosure
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDogSpecificDisclosure newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDogSpecificDisclosure newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDogSpecificDisclosure query()
 * @property int $id
 * @property string $habitat
 * @property bool $dog_school
 * @property bool $time_to_occupy
 * @property string $purpose
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDogSpecificDisclosure whereDogSchool($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDogSpecificDisclosure whereHabitat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDogSpecificDisclosure whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDogSpecificDisclosure wherePurpose($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDogSpecificDisclosure whereTimeToOccupy($value)
 * @mixin \Eloquent
 */
class UserDogSpecificDisclosure extends Model
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
