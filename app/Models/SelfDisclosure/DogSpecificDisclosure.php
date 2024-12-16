<?php

namespace App\Models\SelfDisclosure;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 *
 *
 * @property-read \App\Models\SelfDisclosure\AnimalSpecificDisclosure|null $animalDisclosure
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DogSpecificDisclosure newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DogSpecificDisclosure newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DogSpecificDisclosure query()
 * @property int $id
 * @property string $habitat
 * @property bool $dog_school
 * @property bool $time_to_occupy
 * @property string $purpose
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DogSpecificDisclosure whereDogSchool($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DogSpecificDisclosure whereHabitat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DogSpecificDisclosure whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DogSpecificDisclosure wherePurpose($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DogSpecificDisclosure whereTimeToOccupy($value)
 * @mixin \Eloquent
 */
class DogSpecificDisclosure extends Model
{
    public $timestamps = false;

    public function animalDisclosure(): MorphOne
    {
        return $this->morphOne(AnimalSpecificDisclosure::class, 'specifiable');
    }
}
