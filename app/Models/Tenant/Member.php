<?php

namespace App\Models\Tenant;

use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Permission\Traits\HasRoles;
use Stancl\Tenancy\Contracts\Syncable;
use Stancl\Tenancy\Database\Concerns\ResourceSyncing;

/**
 * 
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member query()
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Role> $roles
 * @property-read int|null $roles_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member permission($permissions, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member role($roles, $guard = null, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Member withoutRole($roles, $guard = null)
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Tenant\OrganisationInvitation> $invitations
 * @property-read int|null $invitations_count
 * @mixin \Eloquent
 */
class Member extends Model implements Syncable
{
    use ResourceSyncing, HasUuids, HasRoles;

    protected $guarded = [];

    protected $guard_name = 'web';

    public function getGlobalIdentifierKeyName(): string
    {
        return 'global_id';
    }

    public function getGlobalIdentifierKey(): string
    {
        return $this->getAttribute($this->getGlobalIdentifierKeyName());
    }

    public function getCentralModelName(): string
    {
        return User::class;
    }

    public function getSyncedAttributeNames(): array
    {
        return [
            'name',
            'email',
        ];
    }

    public function getSyncedCreationAttributes(): array
    {
        return [
            'global_id',
            'name',
            'email',
        ];
    }

    /**
     * Get the invitation for the member.
     */
    public function invitations(): HasMany
    {
        return $this->hasMany(OrganisationInvitation::class);
    }
}
