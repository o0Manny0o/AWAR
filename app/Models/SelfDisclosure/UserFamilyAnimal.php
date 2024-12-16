<?php

namespace App\Models\SelfDisclosure;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 *
 *
 * @property-read \App\Models\SelfDisclosure\UserFamilyMember|null $userFamilyMember
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserFamilyAnimal newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserFamilyAnimal newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserFamilyAnimal query()
 * @property int $id
 * @property string $type
 * @property bool $good_with_animals
 * @property bool $castrated
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserFamilyAnimal whereCastrated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserFamilyAnimal whereGoodWithAnimals($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserFamilyAnimal whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserFamilyAnimal whereType($value)
 * @mixin \Eloquent
 */
class UserFamilyAnimal extends Model
{
    public $timestamps = false;

    /**
     * Get the family member.
     */
    public function userFamilyMember(): MorphOne
    {
        return $this->morphOne(UserFamilyMember::class, 'familyable');
    }
}
