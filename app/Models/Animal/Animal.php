<?php

namespace App\Models\Animal;

use App\Interface\Trackable;
use App\Models\Organisation;
use App\Models\User;
use App\Traits\HasResourcePermissions;
use CloudinaryLabs\CloudinaryLaravel\MediaAlly;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Psr\Http\Message\UriInterface;
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
 * @property string|null $bio
 * @property string|null $abstract
 * @property string|null $published_at
 * @property-read mixed $gallery
 * @property-read bool $can_be_published
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Animal\AnimalHistory> $histories
 * @property-read int|null $histories_count
 * @property-read mixed $images
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \CloudinaryLabs\CloudinaryLaravel\Model\Media> $medially
 * @property-read int|null $medially_count
 * @property-read mixed $thumbnail
 * @method static Builder<static>|Animal onlyTrashed()
 * @method static Builder<static>|Animal whereAbstract($value)
 * @method static Builder<static>|Animal whereBio($value)
 * @method static Builder<static>|Animal wherePublishedAt($value)
 * @method static Builder<static>|Animal withTrashed()
 * @method static Builder<static>|Animal withoutTrashed()
 * @property string|null $sex
 * @property string|null $animal_family_id
 * @method static Builder<static>|Animal whereAnimalFamilyId($value)
 * @method static Builder<static>|Animal whereSex($value)
 * @mixin \Eloquent
 */
class Animal extends Model implements Trackable
{
    use CentralConnection,
        HasResourcePermissions,
        HasUuids,
        SoftDeletes,
        MediaAlly;

    protected $fillable = [
        'name',
        'date_of_birth',
        'sex',
        'organisation_id',
        'bio',
        'abstract',
        'published_at',
    ];

    protected $with = ['animalable'];
    protected $hidden = ['animalable_type', 'animalable_id', 'organisation_id'];

    protected $tracked = [
        'name',
        'date_of_birth',
        'organisation_id',
        'bio',
        'abstract',
        'published_at',
        'added_media',
        'removed_media',
    ];

    protected $appends = [
        'can_be_viewed',
        'can_be_deleted',
        'can_be_updated',
        'can_be_published',
        'thumbnail',
        'gallery',
        'images',
    ];

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

    public function fetchImages()
    {
        return $this->fetchAllMedia()->map(function ($image) {
            return cloudinary()
                ->getImage($image->file_name)
                ->namedTransformation('none')
                ->toUrl();
        });
    }

    /**
     * Get the animal thumbnail
     *
     * @return Attribute
     */
    protected function thumbnail(): Attribute
    {
        return Attribute::make(get: fn() => $this->fetchThumbnail());
    }

    public function fetchThumbnail(): UriInterface|string|null
    {
        $image = $this->fetchFirstMedia();
        if ($image) {
            return cloudinary()
                ->getImage($image->file_name)
                ->namedTransformation('thumbnail')
                ->toUrl();
        }

        return null;
    }

    /**
     * Get the animal thumbnail
     *
     * @return Attribute
     */
    protected function gallery(): Attribute
    {
        return Attribute::make(get: fn() => $this->fetchGallery());
    }

    public function fetchGallery()
    {
        return $this->fetchAllMedia()->map(function ($image) {
            return cloudinary()
                ->getImage($image->file_name)
                ->namedTransformation('gallery')
                ->toUrl();
        });
    }

    /**
     * Get the animal thumbnail
     *
     * @return Attribute
     */
    protected function images(): Attribute
    {
        return Attribute::make(get: fn() => $this->fetchGallery());
    }
}
