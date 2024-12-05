<?php

namespace App\Interface;

use Illuminate\Database\Eloquent\Relations\MorphOne;

interface Animalable
{
    /**
     * @return MorphOne
     */
    public function animal(): MorphOne;
}
