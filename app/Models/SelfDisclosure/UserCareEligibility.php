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

    /**
     * The self disclosure the eligibility belongs to
     */
    public function selfDisclosure(): BelongsTo
    {
        return $this->belongsTo(UserSelfDisclosure::class);
    }
}
