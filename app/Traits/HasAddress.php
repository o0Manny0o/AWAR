<?php

namespace App\Traits;

use App\Models\Address;
use App\Models\Scopes\WithAddressScope;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * @property-read Address $organisation
 */
trait HasAddress
{
    public static function bootHasAddress(): void
    {
        static::addGlobalScope(new WithAddressScope());
    }

    /**
     * Get the model address.
     */
    public function address(): MorphOne
    {
        return $this->morphOne(Address::class, 'addressable');
    }
}
