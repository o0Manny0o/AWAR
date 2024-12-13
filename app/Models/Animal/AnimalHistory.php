<?php

namespace App\Models\Animal;

use App\Enum\AnimalHistoryType;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
 * @property class-string<AnimalHistoryType> $type
 * @property string $global_user_id
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Animal\AnimalChange> $changes
 * @property-read int|null $changes_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AnimalHistory whereGlobalUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AnimalHistory whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder public ()
 * @method static \Illuminate\Database\Eloquent\Builder whole()
 * @property bool $public
 * @property-read \App\Models\Animal\Animal $animal
 * @property-read User $changee
 * @method static Builder<static>|AnimalHistory wherePublic($value)
 * @method static Builder<static>|AnimalHistory public ()
 * @mixin \Eloquent
 */
class AnimalHistory extends Model
{
    use CentralConnection;

    protected $fillable = ['global_user_id', 'type', 'public'];

    public static function internalHistory(Animal $animal): array
    {
        $history = $animal->histories()->whole()->get();

        return $history->map(fn($h) => $h->formattedInternal())->toArray();
    }

    private function formattedInternal(): array
    {
        Carbon::setLocale(\App::getLocale());

        $t = fn($history) => __('history.changes.internal.' . $history->type, [
            'user' => $history->changee->name,
            'animal' => $history->animal->name,
            'when' => $history->created_at->diffForHumans(),
        ]);

        return match ($this->type) {
            default => [
                'text' => $t($this),
                'type' => $this->type,
            ],
        };
    }

    public static function publicHistory(Animal $animal): array
    {
        $history = $animal->histories()->public()->whole()->get();

        return $history->map(fn($h) => $h->formattedPublic())->toArray();
    }

    private function formattedPublic(): array
    {
        Carbon::setLocale(\App::getLocale());

        /**
         * TODO:
         * - Extend types of insert (default: Animal was found)
         */

        $t = fn($history) => __('history.changes.public.' . $history->type, [
            'user' => $history->changee->name,
            'animal' => $history->animal->name,
            'when' => $history->created_at->diffForHumans(),
        ]);

        return match ($this->type) {
            default => [
                'text' => $t($this),
                'type' => $this->type,
            ],
        };
    }

    public function changes(): HasMany
    {
        return $this->hasMany(AnimalChange::class);
    }

    public function changee(): BelongsTo
    {
        return $this->BelongsTo(User::class, 'global_user_id', 'global_id');
    }

    public function animal(): BelongsTo
    {
        return $this->BelongsTo(Animal::class);
    }

    /**
     * Scope a query to only include public changes.
     */
    public function scopePublic(Builder $query): void
    {
        $query->where('public', true);
    }

    public function scopeWhole(Builder $query): void
    {
        $query->with([
            'changes:id,field,value,animal_history_id',
            'changee:global_id,name',
            'animal:id,name',
        ]);
    }
}
