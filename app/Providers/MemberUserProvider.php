<?php

namespace App\Providers;

use Illuminate\Auth\EloquentUserProvider;

// TODO: This causes two db queries for each request.
class MemberUserProvider extends EloquentUserProvider
{
    /**
     * @inheritDoc
     */
    public function retrieveByToken($identifier, #[\SensitiveParameter] $token)
    {
        $user = parent::retrieveById($identifier);
        if (tenancy()->initialized) {
            $user?->append('member');
        }
        return $user;
    }

    /**
     * @inheritDoc
     */
    public function retrieveById($identifier)
    {
        $user = parent::retrieveById($identifier);
        if (tenancy()->initialized) {
            $user?->append('member');
        }
        return $user;
    }
}
