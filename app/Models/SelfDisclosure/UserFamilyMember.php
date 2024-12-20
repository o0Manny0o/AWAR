<?php

namespace App\Models\SelfDisclosure;

use App\Models\Scopes\SelfDisclosureScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 *
 *
 * @property-read Model|\Eloquent $familyable
 * @property-read \App\Models\SelfDisclosure\UserSelfDisclosure|null $selfDisclosure
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserFamilyMember newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserFamilyMember newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserFamilyMember query()
 * @property int $id
 * @property string $name
 * @property int $age
 * @property string $familyable_type
 * @property int $familyable_id
 * @property int $self_disclosure_id
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserFamilyMember whereAge($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserFamilyMember whereFamilyableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserFamilyMember whereFamilyableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserFamilyMember whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserFamilyMember whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserFamilyMember whereSelfDisclosureId($value)
 * @property bool $is_primary
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserFamilyMember whereIsPrimary($value)
 * @property int|null $year
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserFamilyMember whereYear($value)
 * @method static Builder<static>|UserFamilyMember primary()
 * @mixin \Eloquent
 */
#[ScopedBy([SelfDisclosureScope::class])]
class UserFamilyMember extends Model
{
    use HasUuids;

    public $timestamps = false;

    protected $fillable = ['name', 'year', 'self_disclosure_id'];

    protected $with = ['familyable'];

    protected $hidden = [
        'familyable_type',
        'familyable_id',
        'self_disclosure_id',
    ];

    /**
     * The self disclosure the family member belongs to
     */
    public function selfDisclosure(): BelongsTo
    {
        return $this->belongsTo(
            UserSelfDisclosure::class,
            'self_disclosure_id',
        );
    }

    public function familyable(): MorphTo
    {
        return $this->morphTo();
    }

    /** Scope a query to only include primary family members */
    public function scopePrimary(Builder $query): void
    {
        $query->where('is_primary', true)->with('familyable');
    }
}
