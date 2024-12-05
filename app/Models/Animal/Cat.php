<?php

namespace App\Models\Animal;

use App\Interface\Animalable;
use App\Interface\Trackable;
use App\Traits\IsAnimal;
use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Database\Concerns\CentralConnection;

/**
 *
 *
 * @property-read \App\Models\Animal\Animal|null $animal
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cat newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cat newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cat query()
 * @property int $id
 * @property string $breed
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Dog whereBreed($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Dog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Dog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Dog whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Cat extends Model implements Trackable, Animalable
{
    use IsAnimal, CentralConnection;

    public $timestamps = false;
    protected $fillable = ['breed'];
    protected $hidden = ['id'];
    protected array $tracked = ['breed'];

    /**
     * @return string[]
     */
    public function getTracked(): array
    {
        return $this->tracked;
    }
}
