<?php

namespace App\Models;

use App\Events\AddressSaved;
use Clickbar\Magellan\Database\Eloquent\HasPostgisColumns;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Stancl\Tenancy\Database\Concerns\CentralConnection;

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
 * @property string $location
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Address whereLocation($value)
 * @property-read string $address_string
 * @method static \Database\Factories\AddressFactory factory($count = null, $state = [])
 * @method static Builder<static>|Address tenant()
 * @property-read Model|\Eloquent $addressable
 * @method static Builder<static>|Address tenantLocations()
 * @mixin \Eloquent
 */
class Address extends Model
{
    use HasPostgisColumns, HasFactory, CentralConnection;

    protected array $postgisColumns = [
        'location' => [
            'type' => 'geometry',
            'srid' => 4326,
        ],
    ];
    protected $fillable = [
        'street_address',
        'locality',
        'region',
        'postal_code',
        'country_id',
        'location',
    ];

    protected $visible = [
        'id',
        'street_address',
        'region',
        'postal_code',
        'locality',
        'country',
        'distance',
    ];

    protected $with = ['country:code,name,alpha'];

    protected $dispatchesEvents = [
        'saved' => AddressSaved::class,
    ];

    public function addressable(): MorphTo
    {
        return $this->morphTo();
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_id', 'code');
    }

    public function getAddressStringAttribute(): string
    {
        return "{$this->street_address}, {$this->postal_code} {$this->locality}, {$this->region} {$this->country->name}";
    }
}
