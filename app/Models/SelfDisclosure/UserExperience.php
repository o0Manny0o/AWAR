<?php

namespace App\Models\SelfDisclosure;

use App\Models\Scopes\SelfDisclosureScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 *
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserExperience newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserExperience newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserExperience query()
 * @property string $id
 * @property string $type
 * @property string $animal_type
 * @property int $years
 * @property int $self_disclosure_id
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserExperience whereAnimalType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserExperience whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserExperience whereSelfDisclosureId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserExperience whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserExperience whereYears($value)
 * @property-read \App\Models\SelfDisclosure\UserSelfDisclosure $selfDisclosure
 * @property string|null $since
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserExperience whereSince($value)
 * @mixin \Eloquent
 */
#[ScopedBy(SelfDisclosureScope::class)]
class UserExperience extends Model
{
    use HasUuids;

    public $timestamps = false;

    protected $guarded = ['id', 'self_disclosure_id'];

    protected $hidden = ['self_disclosure_id'];

    /**
     * The self disclosure the experience belongs to
     */
    public function selfDisclosure(): BelongsTo
    {
        return $this->belongsTo(
            UserSelfDisclosure::class,
            'self_disclosure_id',
        );
    }
}
