<?php

namespace App\Traits;

use App\Models\Organisation;
use App\Models\Scopes\TenantScope;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property-read Organisation $organisation
 */
trait BelongsToOrganisation
{
    public static function bootBelongsToOrganisation(): void
    {
        static::addGlobalScope(new TenantScope());

        static::creating(function ($model) {
            if (
                !$model->getAttribute('organisation_id') &&
                !$model->relationLoaded('organisation')
            ) {
                if (tenancy()->initialized) {
                    $model->setAttribute(
                        'organisation_id',
                        tenant()->getTenantKey(),
                    );
                    $model->setRelation('tenant', tenant());
                }
            }
        });
    }

    public function organisation(): BelongsTo
    {
        return $this->belongsTo(Organisation::class, 'organisation_id');
    }
}
