<?php

namespace App\Models\Tenant;

use App\Enum\ResourcePermission;
use App\Models\Organisation;
use App\Models\Scopes\TenantScope;
use App\Traits\HasResourcePermissions;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Stancl\Tenancy\Database\Concerns\CentralConnection;

/**
 *
 *
 * @method static \Database\Factories\OrganisationSettingsFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganisationPublicSettings newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganisationPublicSettings newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganisationPublicSettings query()
 * @property int $id
 * @property string|null $favicon
 * @property string $organisation_id
 * @property-read \App\Models\Organisation $organisation
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganisationPublicSettings whereFavicon($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganisationPublicSettings whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganisationPublicSettings whereOrganisationId($value)
 * @property string|null $name
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganisationPublicSettings whereName($value)
 * @mixin \Eloquent
 */
#[ScopedBy([TenantScope::class])]
class OrganisationPublicSettings extends Model
{
    /** @use HasFactory<\Database\Factories\OrganisationSettingsFactory> */
    use HasFactory, CentralConnection, HasResourcePermissions;

    protected $fillable = ['name', 'favicon'];

    protected $hidden = ['organisation_id', 'id'];

    protected $resource_permissions = [
        ResourcePermission::VIEW,
        ResourcePermission::UPDATE,
    ];

    public $timestamps = false;

    public function organisation(): BelongsTo
    {
        return $this->belongsTo(Organisation::class);
    }
}
