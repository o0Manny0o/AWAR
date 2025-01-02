<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Builder;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;
use Stancl\Tenancy\Database\Models\TenantPivot;

/**
 *
 *
 * @method static Builder<static>|Member newModelQuery()
 * @method static Builder<static>|Member newQuery()
 * @method static Builder<static>|Member query()
 * @property-read \App\Models\Organisation|null $tenant
 * @mixin \Eloquent
 */
class Member extends TenantPivot
{
    use BelongsToTenant;
}
