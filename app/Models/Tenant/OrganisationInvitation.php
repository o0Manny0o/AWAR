<?php

namespace App\Models\Tenant;

use App\Traits\HasResourcePermissions;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Permission\Models\Role;

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
 * @property-read bool $can_be_resended
 * @property-read Role|null $role
 * @property-read bool $can_be_published
 * @mixin \Eloquent
 */
class OrganisationInvitation extends Model
{
    use HasUuids, HasResourcePermissions;

    protected $fillable = [
        'email',
        'role_id',
        'token',
        'member_id',
        'status',
        'sent_at',
        'accepted_at',
        'valid_until',
    ];

    protected $appends = ['can_be_viewed', 'can_be_resended'];

    protected $casts = [
        'sent_at' => 'datetime',
        'accepted_at' => 'datetime',
        'valid_until' => 'datetime',
    ];

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function inviter(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function isExpired(): bool
    {
        return $this->valid_until->lessThan(now());
    }

    public function isValid(): bool
    {
        return !$this->isExpired();
    }
}
