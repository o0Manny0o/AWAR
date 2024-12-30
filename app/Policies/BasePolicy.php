<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

abstract class BasePolicy
{
    abstract function isOwner(User $user, Model $entity): bool;

    protected function isMember(User $user): bool
    {
        // TODO: Caching
        if (tenancy()->initialized) {
            return !!$user->whereHas('tenants', function (Builder $query) {
                $query->where('organisations.id', tenant('id'));
            });
        }
        return false;
    }
}
