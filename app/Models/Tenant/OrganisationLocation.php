<?php

namespace App\Models\Tenant;

use App\Enum\ResourcePermission;
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
 * @property string $id
 * @property string $name
 * @property bool $public
 * @property string $organisation_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read bool $can_be_deleted
 * @property-read bool $can_be_published
 * @property-read bool $can_be_resended
 * @property-read bool $can_be_restored
 * @property-read bool $can_be_submitted
 * @property-read bool $can_be_updated
 * @property-read bool $can_be_viewed
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganisationLocation onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganisationLocation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganisationLocation whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganisationLocation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganisationLocation whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganisationLocation whereOrganisationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganisationLocation wherePublic($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganisationLocation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganisationLocation withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganisationLocation withoutTrashed()
 * @mixin \Eloquent
 */
#[ScopedBy([TenantScope::class])]
class OrganisationLocation extends Model
{
    use CentralConnection, SoftDeletes, HasResourcePermissions, HasUuids;

    protected $fillable = ['name', 'public'];

    protected $with = ['address', 'address.country'];

    protected $resourcePermissions = [
        ResourcePermission::DELETE,
        ResourcePermission::VIEW,
        ResourcePermission::UPDATE,
    ];

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
