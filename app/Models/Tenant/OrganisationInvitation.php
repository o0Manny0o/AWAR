<?php

namespace App\Models\Tenant;

use App\Traits\HasResourcePermissions;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * 
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganisationInvitation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganisationInvitation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganisationInvitation query()
 * @property-read \App\Models\Tenant\Member|null $inviter
 * @property-read bool $can_be_deleted
 * @property-read bool $can_be_restored
 * @property-read bool $can_be_submitted
 * @property-read bool $can_be_updated
 * @property-read bool $can_be_viewed
 * @mixin \Eloquent
 */
class OrganisationInvitation extends Model
{
    use HasUuids, HasResourcePermissions;

    protected $fillable = [
        'email',
        'role',
        'token',
        'member_id',
        'status',
        'sent_at',
        'accepted_at'
    ];

    protected $appends = [
        'can_be_deleted',
        'can_be_viewed',
    ];

    public function inviter(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }
}
