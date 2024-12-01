<?php

namespace App\Models;

use Stancl\Tenancy\Database\Models\Domain as BaseDomain;

/**
 * 
 *
 * @property int $id
 * @property string $domain
 * @property string $subdomain
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $organisation_id
 * @property-read \App\Models\Organisation $tenant
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Domain newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Domain newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Domain query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Domain whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Domain whereDomain($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Domain whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Domain whereOrganisationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Domain whereSubdomain($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Domain whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Domain extends BaseDomain
{
    public function tenant()
    {
        return $this->belongsTo(
            config('tenancy.tenant_model'),
            'organisation_id',
        );
    }
}
