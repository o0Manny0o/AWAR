<?php

namespace App\Models\Animal;

use App\Interface\Trackable;
use App\Models\Organisation;
use App\Models\User;
use App\Traits\HasResourcePermissions;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Stancl\Tenancy\Database\Concerns\CentralConnection;

/**
 *
 *
 * @method static Builder<static>|Animal newModelQuery()
 * @method static Builder<static>|Animal newQuery()
 * @method static Builder<static>|Animal query()
 * @property-read Model|\Eloquent $animalable
 * @property int $id
 * @property string $name
 * @property string $date_of_birth
 * @property string $animalable_type
 * @property int $animalable_id
 * @property string $organisation_id
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static Builder<static>|Animal whereAnimalableId($value)
 * @method static Builder<static>|Animal whereAnimalableType($value)
 * @method static Builder<static>|Animal whereCreatedAt($value)
 * @method static Builder<static>|Animal whereDateOfBirth($value)
 * @method static Builder<static>|Animal whereDeletedAt($value)
 * @method static Builder<static>|Animal whereId($value)
 * @method static Builder<static>|Animal whereName($value)
 * @method static Builder<static>|Animal whereOrganisationId($value)
 * @method static Builder<static>|Animal whereUpdatedAt($value)
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @property-read bool $can_be_deleted
 * @property-read bool $can_be_resended
 * @property-read bool $can_be_restored
 * @property-read bool $can_be_submitted
 * @property-read bool $can_be_updated
 * @property-read bool $can_be_viewed
 * @property-read Organisation $organisation
 * @mixin \Eloquent
 */
class Animal extends Model implements Trackable
{
    use CentralConnection, HasResourcePermissions, HasUuids, SoftDeletes;

    protected $fillable = ['name', 'date_of_birth', 'organisation_id'];

    protected $with = ['animalable'];
    protected $hidden = ['animalable_type', 'animalable_id', 'organisation_id'];

    protected $tracked = ['name', 'date_of_birth', 'organisation_id'];

    protected $appends = ['can_be_viewed', 'can_be_deleted', 'can_be_updated'];

    /**
     * @return string[]
     */
    public function getTracked(): array
    {
        return $this->tracked;
    }

    /**
     * Returns all the dogs
     * @return Animal|Builder
     */
    public static function dogs(): Animal|Builder
    {
        return self::subtype(Dog::class);
    }

    private static function subtype($class): Builder|Animal
    {
        return self::where('animalable_type', $class)->whereOrganisationId(
            tenant()->id,
        );
    }

    /**
     * Returns all the cats
     * @return Animal|Builder
     */
    public static function cats(): Animal|Builder
    {
        return self::subtype(Cat::class);
    }

    public function animalable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * The users that are assigned to the animal.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'animal_users',
            'animal_id',
            'global_user_id',
        );
    }

    /**
     * The organisation that the animal belongs to.
     */
    public function organisation(): BelongsTo
    {
        return $this->belongsTo(Organisation::class);
    }

    public function histories(): HasMany
    {
        return $this->hasMany(AnimalHistory::class);
    }
}
