<?php

namespace App\Models\SelfDisclosure;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 *
 *
 * @property-read \App\Models\SelfDisclosure\UserSelfDisclosure|null $selfDisclosure
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserSpecialNeeds newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserSpecialNeeds newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserSpecialNeeds query()
 * @property int $id
 * @property bool $allergies
 * @property bool $handicapped
 * @property int $self_disclosure_id
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserSpecialNeeds whereAllergies($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserSpecialNeeds whereHandicapped($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserSpecialNeeds whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserSpecialNeeds whereSelfDisclosureId($value)
 * @mixin \Eloquent
 */
class UserSpecialNeeds extends Model
{
    public $timestamps = false;

    /**
     * The self disclosure the special needs belongs to
     */
    public function selfDisclosure(): BelongsTo
    {
        return $this->belongsTo(UserSelfDisclosure::class);
    }
}
