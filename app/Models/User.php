<?php

namespace App\Models;

use App\Models\Tenant\Member;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Stancl\Tenancy\Contracts\SyncMaster;
use Stancl\Tenancy\Database\Concerns\CentralConnection;
use Stancl\Tenancy\Database\Concerns\ResourceSyncing;
use Stancl\Tenancy\Database\Models\TenantPivot;

/**
 *
 *
 * @property string $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\OrganisationApplication> $organisationApplications
 * @property-read int|null $organisation_applications_count
 * @property-read TenantPivot|null $pivot
 * @property-read \Stancl\Tenancy\Database\TenantCollection<int, \App\Models\Organisation> $tenants
 * @property-read int|null $tenants_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Role> $roles
 * @property-read int|null $roles_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User permission($permissions, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User role($roles, $guard = null, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutRole($roles, $guard = null)
 * @property string $global_id
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereGlobalId($value)
 * @mixin \Eloquent
 */
class User extends Authenticatable implements SyncMaster, MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory,
        Notifiable,
        CentralConnection,
        ResourceSyncing,
        HasUuids,
        HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name', 'email', 'password'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function organisationApplications(): HasMany
    {
        return $this->hasMany(OrganisationApplication::class);
    }

    public function tenants(): BelongsToMany
    {
        return $this->belongsToMany(
            Organisation::class,
            'organisation_users',
            'global_user_id',
            'tenant_id',
            'global_id',
        )
            ->using(TenantPivot::class)
            ->withTimestamps();
    }

    public function getTenantModelName(): string
    {
        return Member::class;
    }

    public function getGlobalIdentifierKeyName(): string
    {
        return 'global_id';
    }

    public function getGlobalIdentifierKey()
    {
        return $this->getAttribute($this->getGlobalIdentifierKeyName());
    }

    public function getCentralModelName(): string
    {
        return static::class;
    }

    public function getSyncedAttributeNames(): array
    {
        return ['name', 'email'];
    }

    public function getSyncedCreationAttributes(): array
    {
        return ['global_id', 'name', 'email'];
    }

    public function asMember(string $organisationId = null): Member|null
    {
        if ($organisationId) {
            $organisation = Organisation::find($organisationId);
            if ($organisation) {
                tenancy()->initialize($organisation);
            }
        }

        if (!tenancy()) {
            // Currently not in organisation context
            return null;
        }
        /** @var Member|null $member */
        $member = Member::firstWhere('global_id', $this->global_id);
        return $member;
    }
}
