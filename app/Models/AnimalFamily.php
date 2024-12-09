<?php

namespace App\Models;

use App\Models\Animal\Animal;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 *
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AnimalFamily newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AnimalFamily newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AnimalFamily query()
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AnimalFamily whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AnimalFamily whereFatherId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AnimalFamily whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AnimalFamily whereMotherId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AnimalFamily whereSiblingsGrouped($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AnimalFamily whereUpdatedAt($value)
 * @property string|null $name
 * @property string|null $bio
 * @property string|null $abstract
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AnimalFamily whereAbstract($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AnimalFamily whereBio($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AnimalFamily whereName($value)
 * @mixin \Eloquent
 */
class AnimalFamily extends Model
{
    use HasUuids;

    protected $fillable = ['siblings_grouped', 'name'];

    public function children(): HasMany
    {
        return $this->hasMany(Animal::class);
    }

    public function father(): BelongsTo
    {
        return $this->belongsTo(Animal::class);
    }

    public function mother(): BelongsTo
    {
        return $this->belongsTo(Animal::class);
    }
}
