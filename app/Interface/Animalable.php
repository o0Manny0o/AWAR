<?php

namespace App\Interface;

use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * @property-read string $baseViewPath
 * @property-read string $baseRouteName
 * @property-read string $type
 */
interface Animalable
{
    /**
     * @return MorphOne
     */
    public function animal(): MorphOne;
}
