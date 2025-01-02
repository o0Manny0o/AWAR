<?php

namespace App\Models\Animal;

use App\Models\Organisation;
use App\Models\Scopes\WithAnimalableScope;
use App\Models\Scopes\WithRelativesScope;
use App\Traits\BelongsToOrganisation;
use App\Traits\HasMorphableScopes;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 *
 *
 * @method static Builder<static>|AnimalFamily newModelQuery()
 * @method static Builder<static>|AnimalFamily newQuery()
 * @method static Builder<static>|AnimalFamily query()
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Animal> $children
 * @property-read int|null $children_count
 * @property-read Animal|null $father
 * @property-read Animal|null $mother
 * @property string $id
 * @property bool $siblings_grouped
 * @property string|null $father_id
 * @property string|null $mother_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static Builder<static>|AnimalFamily whereCreatedAt($value)
 * @method static Builder<static>|AnimalFamily whereFatherId($value)
 * @method static Builder<static>|AnimalFamily whereId($value)
 * @method static Builder<static>|AnimalFamily whereMotherId($value)
 * @method static Builder<static>|AnimalFamily whereSiblingsGrouped($value)
 * @method static Builder<static>|AnimalFamily whereUpdatedAt($value)
 * @property string|null $name
 * @property string|null $bio
 * @property string|null $abstract
 * @method static Builder<static>|AnimalFamily whereAbstract($value)
 * @method static Builder<static>|AnimalFamily whereBio($value)
 * @method static Builder<static>|AnimalFamily whereName($value)
 * @property string $family_type
 * @property string $organisation_id
 * @property-read Organisation $organisation
 * @method static Builder<static>|AnimalFamily cats()
 * @method static Builder<static>|AnimalFamily dogs()
 * @method static Builder<static>|AnimalFamily subtype(string $type)
 * @method static Builder<static>|AnimalFamily whereFamilyType($value)
 * @method static Builder<static>|AnimalFamily whereOrganisationId($value)
 * @mixin \Eloquent
 */
#[ScopedBy([WithRelativesScope::class])]
class AnimalFamily extends Model
{
    use HasUuids, HasMorphableScopes, BelongsToOrganisation;

    protected static string $morphTypeColumn = 'family_type';

    protected $fillable = [
        'name',
        'organisation_id',
        'family_type',
        'father_id',
        'mother_id',
        'bio',
        'abstract',
    ];

    protected $hidden = [
        'family_type',
        'organisation_id',
        'father_id',
        'mother_id',
    ];

    public function children(): HasMany
    {
        return $this->hasMany(Animal::class);
    }

    public function father(): BelongsTo
    {
        return $this->belongsTo(Animal::class, 'father_id')->withoutGlobalScope(
            WithAnimalableScope::class,
        );
    }

    public function mother(): BelongsTo
    {
        return $this->belongsTo(Animal::class, 'mother_id')->withoutGlobalScope(
            WithAnimalableScope::class,
        );
    }
}
