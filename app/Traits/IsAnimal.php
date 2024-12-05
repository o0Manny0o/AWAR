<?php

namespace App\Traits;

use App\Models\Animal\Animal;
use Illuminate\Database\Eloquent\Relations\MorphOne;

trait IsAnimal
{
    public function animal(): MorphOne
    {
        return $this->morphOne(Animal::class, 'animalable')->chaperone();
    }
}
