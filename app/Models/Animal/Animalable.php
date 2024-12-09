<?php

namespace App\Models\Animal;

use App\Interface\Trackable;
use App\Traits\IsAnimal;
use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Database\Concerns\CentralConnection;

/**
 *
 *
 * @property-read \App\Models\Animal\Animal|null $animal
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Animalable newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Animalable newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Animalable query()
 * @mixin \Eloquent
 */
class Animalable extends Model implements Trackable, \App\Interface\Animalable
{
    use IsAnimal, CentralConnection;

    public $timestamps = false;

    /**
     * @inheritDoc
     */
    public function getTracked(): array
    {
        return $this->tracked;
    }

    public function delete($id = null)
    {
        $this->animal()->delete();
    }
}
