<?php

namespace App\Models\Animal;

use App\Trackable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;
use Stancl\Tenancy\Database\Concerns\CentralConnection;

/**
 *
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AnimalHistory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AnimalHistory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AnimalHistory query()
 * @property int $id
 * @property string $animal_id
 * @property string $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AnimalHistory whereAnimalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AnimalHistory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AnimalHistory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AnimalHistory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AnimalHistory whereUserId($value)
 * @mixin \Eloquent
 */
class AnimalHistory extends Model
{
    use CentralConnection;

    protected $fillable = ['global_user_id', 'type'];

    public function changes(): HasMany
    {
        return $this->hasMany(AnimalChange::class);
    }

    public static function createInitialEntry(Animal $animal)
    {
        /** @var Trackable $animalable */
        $animalable = $animal->animalable;

        /** @var AnimalHistory $history */
        $history = $animal->histories()->create([
            'global_user_id' => Auth::user()->global_id,
        ]);
        $history->changes()->createMany(
            array_merge(
                array_map(
                    fn($col) => [
                        'field' => $col,
                        'value' => $animal[$col],
                    ],
                    $animal->getTracked(),
                ),
                array_map(
                    fn($col) => [
                        'field' => $col,
                        'value' => $animalable[$col],
                    ],
                    $animalable->getTracked(),
                ),
            ),
        );
    }

    public static function createUpdateEntry(Animal $animal)
    {
        /** @var Trackable $animalable */
        $animalable = $animal->animalable;

        /** @var AnimalHistory $history */
        $history = $animal->histories()->create([
            'global_user_id' => Auth::user()->global_id,
            'type' => 'update',
        ]);
    }
}
