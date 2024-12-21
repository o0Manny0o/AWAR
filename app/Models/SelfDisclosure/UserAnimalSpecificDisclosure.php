<?php

namespace App\Models\SelfDisclosure;

use App\Models\Scopes\SelfDisclosureScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 *
 *
 * @property-read \App\Models\SelfDisclosure\UserSelfDisclosure|null $selfDisclosure
 * @property-read Model|\Eloquent $specifiable
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserAnimalSpecificDisclosure newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserAnimalSpecificDisclosure newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserAnimalSpecificDisclosure query()
 * @property int $id
 * @property string $specifiable_type
 * @property int $specifiable_id
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserAnimalSpecificDisclosure whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserAnimalSpecificDisclosure whereSpecifiableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserAnimalSpecificDisclosure whereSpecifiableType($value)
 * @property int $self_disclosure_id
 * @method static Builder<static>|UserAnimalSpecificDisclosure cat()
 * @method static Builder<static>|UserAnimalSpecificDisclosure dog()
 * @method static Builder<static>|UserAnimalSpecificDisclosure whereSelfDisclosureId($value)
 * @mixin \Eloquent
 */
#[ScopedBy(SelfDisclosureScope::class)]
class UserAnimalSpecificDisclosure extends Model
{
    public $timestamps = false;

    protected $fillable = ['self_disclosure_id'];

    protected $hidden = [
        'id',
        'self_disclosure_id',
        'specifiable_type',
        'specifiable_id',
    ];

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

    public function scopeCat(Builder $query)
    {
        $query
            ->with('specifiable')
            ->whereHasMorph('specifiable', UserCatSpecificDisclosure::class);
    }

    public function scopeDog(Builder $query): void
    {
        $query
            ->with('specifiable')
            ->whereHasMorph('specifiable', UserDogSpecificDisclosure::class);
    }
}
