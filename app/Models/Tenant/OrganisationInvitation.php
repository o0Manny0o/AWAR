<?php

namespace App\Models\Tenant;

use App\Enum\ResourcePermission;
use App\Models\User;
use App\Traits\BelongsToOrganisation;
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
 * @property string $id
 * @property string $email
 * @property string $token
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $sent_at
 * @property \Illuminate\Support\Carbon|null $accepted_at
 * @property \Illuminate\Support\Carbon|null $valid_until
 * @property string $user_id
 * @property string $organisation_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Organisation $organisation
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganisationInvitation whereAcceptedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganisationInvitation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganisationInvitation whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganisationInvitation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganisationInvitation whereOrganisationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganisationInvitation whereSentAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganisationInvitation whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganisationInvitation whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganisationInvitation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganisationInvitation whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganisationInvitation whereValidUntil($value)
 * @mixin \Eloquent
 */
class OrganisationInvitation extends Model
{
    use HasUuids, HasResourcePermissions, BelongsToOrganisation;

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

    protected array $resource_permissions = [
        ResourcePermission::VIEW,
        ResourcePermission::RESEND,
    ];

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
        return $this->belongsTo(User::class);
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
