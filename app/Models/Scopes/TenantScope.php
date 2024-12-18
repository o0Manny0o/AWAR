<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class TenantScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        $builder->when(
            tenant(),
            function (Builder $query) {
                return $query->where('organisation_id', tenant()->id);
            },
            function (Builder $query) {
                return $query->with(['organisation']);
            },
        );
    }
}
