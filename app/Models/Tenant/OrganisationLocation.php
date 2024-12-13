<?php

namespace App\Models\Tenant;

use App\Models\Address;
use App\Models\Organisation;
use App\Models\Scopes\TenantScope;
use App\Traits\HasResourcePermissions;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Stancl\Tenancy\Database\Concerns\CentralConnection;

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
#[ScopedBy([TenantScope::class])]
class OrganisationLocation extends Model
{
    use CentralConnection, SoftDeletes, HasResourcePermissions, HasUuids;

    protected $fillable = ['name', 'public'];

    protected $with = ['address', 'address.country'];

    protected $appends = ['can_be_deleted', 'can_be_viewed', 'can_be_updated'];

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
