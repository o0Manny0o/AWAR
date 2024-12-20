<?php

namespace App\Models\SelfDisclosure;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 *
 *
 * @property-read \App\Models\SelfDisclosure\UserSelfDisclosure|null $selfDisclosure
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserCareEligibility newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserCareEligibility newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserCareEligibility query()
 * @property int $id
 * @property bool $animal_protection_experience
 * @property bool $can_cover_expenses
 * @property bool $can_cover_emergencies
 * @property bool $can_afford_insurance
 * @property bool $can_afford_castration
 * @property string|null $substitute
 * @property int $time_alone_daily
 * @property int $self_disclosure_id
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserCareEligibility whereAnimalProtectionExperience($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserCareEligibility whereCanAffordCastration($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserCareEligibility whereCanAffordInsurance($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserCareEligibility whereCanCoverEmergencies($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserCareEligibility whereCanCoverExpenses($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserCareEligibility whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserCareEligibility whereSelfDisclosureId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserCareEligibility whereSubstitute($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserCareEligibility whereTimeAloneDaily($value)
 * @mixin \Eloquent
 */
class UserCareEligibility extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'animal_protection_experience',
        'can_cover_expenses',
        'can_cover_emergencies',
        'can_afford_insurance',
        'can_afford_castration',
        'substitute',
        'time_alone_daily',
    ];

    /**
     * The self disclosure the eligibility belongs to
     */
    public function selfDisclosure(): BelongsTo
    {
        return $this->belongsTo(UserSelfDisclosure::class);
    }
}
