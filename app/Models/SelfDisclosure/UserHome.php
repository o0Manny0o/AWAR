<?php

namespace App\Models\SelfDisclosure;

use App\Models\Scopes\SelfDisclosureScope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 *
 *
 * @property-read \App\Models\SelfDisclosure\UserSelfDisclosure|null $selfDisclosure
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserHome newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserHome newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserHome query()
 * @property int $id
 * @property string $type
 * @property bool $own
 * @property bool $pets_allowed
 * @property string $move_in_date
 * @property int $size
 * @property int $level
 * @property string $location
 * @property bool $garden
 * @property int|null $garden_size
 * @property bool|null $garden_secure
 * @property bool|null $garden_connected
 * @property int $self_disclosure_id
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserHome whereGarden($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserHome whereGardenConnected($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserHome whereGardenSecure($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserHome whereGardenSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserHome whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserHome whereLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserHome whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserHome whereMoveInDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserHome whereOwn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserHome wherePetsAllowed($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserHome whereSelfDisclosureId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserHome whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserHome whereType($value)
 * @method static Builder<static>|UserHome home()
 * @method static Builder<static>|UserHome garden()
 * @mixin \Eloquent
 */
#[ScopedBy([SelfDisclosureScope::class])]
class UserHome extends Model
{
    public $timestamps = false;

    protected $guarded = ['id', 'self_disclosure_id'];

    /**
     * The self disclosure the home belongs to
     */
    public function selfDisclosure(): BelongsTo
    {
        return $this->belongsTo(UserSelfDisclosure::class);
    }

    public function scopeHome(Builder $query): void
    {
        $query->select([
            'id',
            'type',
            'own',
            'pets_allowed',
            'move_in_date',
            'size',
            'level',
            'location',
        ]);
    }

    public function scopeGarden(Builder $query): void
    {
        $query->select([
            'id',
            'garden',
            'garden_size',
            'garden_secure',
            'garden_connected',
        ]);
    }
}
