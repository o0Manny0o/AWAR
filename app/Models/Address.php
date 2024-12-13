<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 *
 *
 * @property int $id
 * @property string $street_address
 * @property string $locality
 * @property string $region
 * @property string $postal_code
 * @property int $country_id
 * @property string $addressable_type
 * @property string $addressable_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Country|null $country
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereAddressableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereAddressableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereLocality($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address wherePostalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereStreetAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereUpdatedAt($value)
 * @property-read Model|\Eloquent $user
 * @mixin \Eloquent
 */
class Address extends Model
{
    protected $fillable = [
        'street_address',
        'locality',
        'region',
        'postal_code',
        'country_id',
    ];

    public function country(): HasOne
    {
        return $this->hasOne(Country::class);
    }
}
