<?php

namespace App\Models\SelfDisclosure;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 *
 *
 * @property-read \App\Models\SelfDisclosure\UserSelfDisclosure|null $selfDisclosure
 * @property-read Model|\Eloquent $specifiable
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AnimalSpecificDisclosure newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AnimalSpecificDisclosure newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AnimalSpecificDisclosure query()
 * @property int $id
 * @property string $specifiable_type
 * @property int $specifiable_id
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AnimalSpecificDisclosure whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AnimalSpecificDisclosure whereSpecifiableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AnimalSpecificDisclosure whereSpecifiableType($value)
 * @mixin \Eloquent
 */
class AnimalSpecificDisclosure extends Model
{
    public $timestamps = false;

    /**
     * The self disclosure the eligibility belongs to
     */
    public function selfDisclosure(): BelongsTo
    {
        return $this->belongsTo(UserSelfDisclosure::class);
    }

    public function specifiable(): MorphTo
    {
        return $this->morphTo();
    }
}
