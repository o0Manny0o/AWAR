<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 *
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganisationInvitation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganisationInvitation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganisationInvitation query()
 * @mixin \Eloquent
 */
class OrganisationInvitation extends Model
{
    use HasUuids;

    protected $fillable = [
        'email',
        'role',
        'token',
        'staff_id',
    ];

    public function inviter(): BelongsTo
    {
        return $this->belongsTo(Staff::class);
    }
}
