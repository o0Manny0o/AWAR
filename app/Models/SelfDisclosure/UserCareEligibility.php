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
