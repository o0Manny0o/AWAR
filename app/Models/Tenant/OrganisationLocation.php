<?php

namespace App\Models\Tenant;

use App\Enum\ResourcePermission;
use App\Traits\BelongsToOrganisation;
use App\Traits\HasAddress;
use App\Traits\HasResourcePermissions;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 *
 *
 * @property string $id
 * @property string $name
 * @property bool $public
 * @property string $organisation_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Address|null $address
 * @property-read \App\Models\Organisation $organisation
 * @method static \Database\Factories\Tenant\OrganisationLocationFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganisationLocation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganisationLocation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganisationLocation onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganisationLocation query()
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
class OrganisationLocation extends Model
{
    use SoftDeletes,
        HasResourcePermissions,
        HasUuids,
        HasFactory,
        BelongsToOrganisation,
        HasAddress;

    protected $fillable = ['name', 'public'];

    protected $resource_permissions = [
        ResourcePermission::DELETE,
        ResourcePermission::VIEW,
        ResourcePermission::UPDATE,
    ];
}
