<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 *
 *
 * @property-read \App\Models\Organisation|null $organisation
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganisationLocation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganisationLocation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganisationLocation query()
 * @property-read \App\Models\Address|null $address
 * @mixin \Eloquent
 */
class OrganisationLocation extends Model
{
    /**
     * Get the organisation that owns the location.
     */
    public function organisation(): BelongsTo
    {
        return $this->belongsTo(Organisation::class);
    }

    /**
     * Get the location address.
     */
    public function address(): MorphOne
    {
        return $this->morphOne(Address::class, 'addressable');
    }
}
