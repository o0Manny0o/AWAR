<?php

namespace App\Models\SelfDisclosure;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 *
 *
 * @property-read \App\Models\SelfDisclosure\UserFamilyMember|null $userFamilyMember
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserFamilyHuman newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserFamilyHuman newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserFamilyHuman query()
 * @property int $id
 * @property string|null $profession
 * @property bool $knows_animals
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserFamilyHuman whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserFamilyHuman whereKnowsAnimals($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserFamilyHuman whereProfession($value)
 * @mixin \Eloquent
 */
class UserFamilyHuman extends Model
{
    public $timestamps = false;

    protected $guarded = [];

    /**
     * Get the family member.
     */
    public function userFamilyMember(): MorphOne
    {
        return $this->morphOne(UserFamilyMember::class, 'familyable');
    }
}
