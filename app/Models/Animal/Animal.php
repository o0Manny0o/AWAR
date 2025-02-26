<?php

namespace App\Models\Animal;

use App\Authorisation\Enum\OrganisationModule;
use App\Authorisation\Enum\PermissionType;
use App\Enum\ResourcePermission;
use App\Interface\Trackable;
use App\Models\Animal\Listing\Listing;
use App\Models\Animal\Listing\ListingAnimal;
use App\Models\Organisation;
use App\Models\Scopes\WithAddressScope;
use App\Models\Scopes\WithAnimalableScope;
use App\Models\Tenant\OrganisationLocation;
use App\Models\User;
use App\Traits\BelongsToOrganisation;
use App\Traits\HasMorphableScopes;
use App\Traits\HasResourcePermissions;
use App\Traits\MediaAlly;
use App\Traits\OptionalAppends;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Validation\UnauthorizedException;

/**
 *
 *
 * @property string $id
 * @property string $name
 * @property string $date_of_birth
 * @property string|null $bio
 * @property string|null $sex
 * @property string|null $published_at
 * @property string $animalable_type
 * @property int $animalable_id
 * @property string $organisation_id
 * @property string|null $handler_id
 * @property string|null $foster_home_id
 * @property string|null $locationable_type
 * @property string|null $locationable_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $animal_family_id
 * @property-read Model|\Eloquent $animalable
 * @property-read \Illuminate\Database\Eloquent\Collection<int, User> $assignedTo
 * @property-read int|null $assigned_to_count
 * @property-read \App\Models\Animal\AnimalFamily|null $family
 * @property-read mixed $gallery
 * @property-read mixed $father
 * @property-read \App\Models\User|null $foster_home
 * @property-read \App\Models\User|null $handler
 * @property-read \App\Models\User|\App\Models\Tenant\OrganisationLocation|null $location
 * @property-read mixed $mother
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Animal\AnimalHistory> $histories
 * @property-read int|null $histories_count
 * @property-read mixed $images
 * @property-read Model|\Eloquent|null $locationable
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Animal\AnimalFamily> $maternalFamilies
 * @property-read int|null $maternal_families_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \CloudinaryLabs\CloudinaryLaravel\Model\Media> $medially
 * @property-read int|null $medially_count
 * @property-read Organisation $organisation
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Animal\AnimalFamily> $paternalFamilies
 * @property-read int|null $paternal_families_count
 * @property-read mixed $thumbnail
 * @method static Builder<static>|Animal asOption()
 * @method static Builder<static>|Animal byPermission(\App\Models\User $user)
 * @method static Builder<static>|Animal cats()
 * @method static Builder<static>|Animal dogs()
 * @method static Builder<static>|Animal newModelQuery()
 * @method static Builder<static>|Animal newQuery()
 * @method static Builder<static>|Animal onlyTrashed()
 * @method static Builder<static>|Animal query()
 * @method static Builder<static>|Animal subtype(string $type)
 * @method static Builder<static>|Animal whereAnimalFamilyId($value)
 * @method static Builder<static>|Animal whereAnimalableId($value)
 * @method static Builder<static>|Animal whereAnimalableType($value)
 * @method static Builder<static>|Animal whereBio($value)
 * @method static Builder<static>|Animal whereCreatedAt($value)
 * @method static Builder<static>|Animal whereDateOfBirth($value)
 * @method static Builder<static>|Animal whereDeletedAt($value)
 * @method static Builder<static>|Animal whereFosterHomeId($value)
 * @method static Builder<static>|Animal whereHandlerId($value)
 * @method static Builder<static>|Animal whereId($value)
 * @method static Builder<static>|Animal whereLocationableId($value)
 * @method static Builder<static>|Animal whereLocationableType($value)
 * @method static Builder<static>|Animal whereName($value)
 * @method static Builder<static>|Animal whereOrganisationId($value)
 * @method static Builder<static>|Animal wherePublishedAt($value)
 * @method static Builder<static>|Animal whereSex($value)
 * @method static Builder<static>|Animal whereUpdatedAt($value)
 * @method static Builder<static>|Animal withMedia()
 * @method static Builder<static>|Animal withTrashed()
 * @method static Builder<static>|Animal withoutTrashed()
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Animal\Listing\Listing> $listings
 * @property-read int|null $listings_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \CloudinaryLabs\CloudinaryLaravel\Model\Media> $baseMedially
 * @property-read int|null $base_medially_count
 * @property-read mixed $media
 * @property-read ListingAnimal|null $pivot
 * @mixin \Eloquent
 */
#[ScopedBy([WithAnimalableScope::class])]
class Animal extends Model implements Trackable
{
    use HasResourcePermissions,
        HasUuids,
        SoftDeletes,
        MediaAlly,
        HasMorphableScopes,
        OptionalAppends,
        BelongsToOrganisation;

    protected $fillable = [
        'name',
        'date_of_birth',
        'sex',
        'organisation_id',
        'bio',
        'published_at',
        'family_id',
        'animal_family_id',
        'handler_id',
        'foster_home_id',
        'locationable_type',
        'locationable_id',
    ];

    protected $hidden = [
        'animalable_type',
        'animalable_id',
        'organisation_id',
        'medially',
    ];

    protected $tracked = [
        'name',
        'date_of_birth',
        'organisation_id',
        'bio',
        'sex',
        'published_at',
        'added_media',
        'removed_media',
        'animal_family_id',
        'father_added',
        'mother_added',
        'father_removed',
        'mother_removed',
        'handler_id',
    ];

    protected array $resource_permissions = [
        ResourcePermission::VIEW,
        ResourcePermission::DELETE,
        ResourcePermission::UPDATE,
        ResourcePermission::PUBLISH,
        ResourcePermission::ASSIGN,
        ResourcePermission::ASSIGN_LOCATION,
        ResourcePermission::ASSIGN_FOSTER_HOME,
    ];

    protected $appends = ['thumbnail', 'gallery', 'images'];

    protected $with = ['medially'];

    /**
     * @return string[]
     */
    public function getTracked(): array
    {
        return $this->tracked;
    }

    public function animalable(): MorphTo
    {
        return $this->morphTo();
    }

    public function locationable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * The users that are assigned to the animal.
     */
    public function assignedTo(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'animal_users',
            'animal_id',
            'id',
        );
    }

    public function histories(): HasMany
    {
        return $this->hasMany(AnimalHistory::class);
    }

    public function fetchImages()
    {
        return $this->fetchAllMedia()->map(function ($image) {
            return cloudinary()
                ->getImage($image->file_name)
                ->namedTransformation('none')
                ->toUrl();
        });
    }

    public function scopeAsOption(Builder $builder): void
    {
        $builder
            ->withoutGlobalScope(WithAnimalableScope::class)
            ->select(['id', 'name', 'sex']);
    }

    public function scopeWithMedia(Builder $builder): void
    {
        $builder->with([
            'medially' => function ($query) {
                return $query->select(
                    'id',
                    'file_url',
                    'medially_id',
                    'medially_type',
                );
            },
        ]);
    }

    public function paternalFamilies()
    {
        return $this->hasMany(AnimalFamily::class, 'father_id');
    }

    public function maternalFamilies()
    {
        return $this->hasMany(AnimalFamily::class, 'mother_id');
    }

    public function getFatherAttribute()
    {
        return $this->family()->pluck('father_id')->first();
    }

    /**
     * The family that the animal belongs to.
     */
    public function family(): BelongsTo
    {
        return $this->belongsTo(AnimalFamily::class, 'animal_family_id');
    }

    public function getMotherAttribute()
    {
        return $this->family()->pluck('mother_id')->first();
    }

    /**
     * The handler that is assigned to the animal
     */
    public function getHandlerAttribute(): ?User
    {
        return tenant()->run(function () {
            return User::whereId($this->handler_id)
                ->select(['id', 'name'])
                ->first();
        });
    }

    /**
     * The handler that is assigned to the animal
     */
    public function getFosterHomeAttribute(): ?User
    {
        return tenant()->run(function () {
            return User::whereId($this->foster_home_id)
                ->select(['id', 'name'])
                ->first();
        });
    }

    /**
     * The handler that is assigned to the animal
     */
    public function getLocationAttribute(): User|OrganisationLocation|null
    {
        if ($this->locationable_type === User::class) {
            return User::whereId($this->locationable_id)
                ->select(['id', 'name'])
                ->first();
        } elseif ($this->locationable_type === OrganisationLocation::class) {
            return OrganisationLocation::withoutGlobalScope(
                WithAddressScope::class,
            )
                ->where('id', $this->locationable_id)
                ->select(['id', 'name'])
                ->first();
        } else {
            return null;
        }
    }

    public function scopeByPermission(Builder $builder, User $user): void
    {
        if (
            $user->hasPermissionTo(
                PermissionType::READ->for(OrganisationModule::ANIMALS->value),
            )
        ) {
            return;
        } elseif (
            $user->hasPermissionTo(
                PermissionType::READ->for(
                    OrganisationModule::ASSIGNED_ANIMALS->value,
                ),
            )
        ) {
            $builder
                ->where('foster_home_id', $user->id)
                ->orWhere('handler_id', $user->id);
        } else {
            throw new UnauthorizedException();
        }
    }

    public function listings(): BelongsToMany
    {
        return $this->belongsToMany(
            Listing::class,
            'listing_animals',
            'animal_id',
            'listing_id',
        )->using(ListingAnimal::class);
    }
}
