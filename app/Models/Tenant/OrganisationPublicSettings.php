<?php

namespace App\Models\Tenant;

use App\Enum\ResourcePermission;
use App\Traits\BelongsToOrganisation;
use App\Traits\HasResourcePermissions;
use Illuminate\Database\Eloquent\Model;

/**
 *
 *
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
 * @property string|null $logo
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganisationPublicSettings whereLogo($value)
 * @mixin \Eloquent
 */
class OrganisationPublicSettings extends Model
{
    use HasResourcePermissions, BelongsToOrganisation;

    protected $fillable = ['name', 'favicon', 'organisation_id', 'logo'];

    protected $hidden = ['organisation_id', 'id'];

    protected $resource_permissions = [
        ResourcePermission::VIEW,
        ResourcePermission::UPDATE,
    ];

    public $timestamps = false;
}
