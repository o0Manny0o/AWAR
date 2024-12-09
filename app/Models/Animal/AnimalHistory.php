<?php

namespace App\Models\Animal;

use App\Events\Animals\AnimalCreated;
use App\Events\Animals\AnimalDeleted;
use App\Events\Animals\AnimalUpdated;
use App\Interface\Trackable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
 * @property string $type
 * @property string $global_user_id
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Animal\AnimalChange> $changes
 * @property-read int|null $changes_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AnimalHistory whereGlobalUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AnimalHistory whereType($value)
 * @mixin \Eloquent
 */
class AnimalHistory extends Model
{
    use CentralConnection;

    protected $fillable = ['global_user_id', 'type'];

    public static function createInitialEntry(AnimalCreated $event): void
    {
        /** @var Trackable $animalable */
        $animalable = $event->animal->animalable;
        $animal = $event->animal;

        /** @var AnimalHistory $history */
        $history = $animal->histories()->create([
            'global_user_id' => $event->user->global_id,
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

    public function changes(): HasMany
    {
        return $this->hasMany(AnimalChange::class);
    }

    public static function createUpdateEntry(AnimalUpdated $event): void
    {
        /** @var Trackable $animalable */
        $animalable = $event->animal->animalable;
        $animal = $event->animal;

        $animalChanges = array_intersect_key(
            $event->changes,
            array_flip($animal->getTracked()),
        );
        $animalableChanges = array_intersect_key(
            $event->changes,
            array_flip($animalable->getTracked()),
        );

        if (empty($animalChanges) && empty($animalableChanges)) {
            return;
        }

        /** @var AnimalHistory $history */
        $history = $animal->histories()->create([
            'global_user_id' => $event->user->global_id,
            'type' => 'update',
        ]);

        $history->changes()->createMany(
            array_merge(
                array_map(
                    fn($col, $val) => [
                        'field' => $col,
                        'value' => $val,
                    ],
                    array_keys($animalChanges),
                    array_values($animalChanges),
                ),
                array_map(
                    fn($col, $val) => [
                        'field' => $col,
                        'value' => $val,
                    ],
                    array_keys($animalableChanges),
                    array_values($animalableChanges),
                ),
            ),
        );
    }

    public static function createDeleteEntry(AnimalDeleted $event): void
    {
        /** @var AnimalHistory $history */
        $event->animal->histories()->create([
            'global_user_id' => $event->user->global_id,
            'type' => 'delete',
        ]);
    }
}
