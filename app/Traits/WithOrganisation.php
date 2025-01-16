<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait WithOrganisation
{
    public function scopeWithOrganisation(Builder $builder)
    {
        $builder->with('tenants');
    }
}
