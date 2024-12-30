<?php

namespace App\Models;

use App\Authorisation\Enum\OrganisationRole;
use App\Events\UserCreated;
use App\Models\Animal\Animal;
use App\Models\SelfDisclosure\UserSelfDisclosure;
use App\Models\Tenant\Member;
use App\Models\Tenant\OrganisationInvitation;
use Database\Factories\UserFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Translation\HasLocalePreference;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Stancl\Tenancy\Database\Models\TenantPivot;

/**
 *
 *
 * @property string $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string $locale
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Address|null $address
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Animal> $animals
 * @property-read int|null $animals_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, OrganisationInvitation> $invitations
 * @property-read int|null $invitations_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\OrganisationApplication> $organisationApplications
 * @property-read int|null $organisation_applications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read UserSelfDisclosure|null $selfDisclosure
 * @property-read TenantPivot|null $pivot
 * @property-read \Stancl\Tenancy\Database\TenantCollection<int, \App\Models\Organisation> $tenants
 * @property-read int|null $tenants_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static Builder<static>|User newModelQuery()
 * @method static Builder<static>|User newQuery()
 * @method static Builder<static>|User permission($permissions, $without = false)
 * @method static Builder<static>|User query()
 * @method static Builder<static>|User role($roles, $guard = null, $without = false)
 * @method static Builder<static>|User tenant()
 * @method static Builder<static>|User whereCreatedAt($value)
 * @method static Builder<static>|User whereEmail($value)
 * @method static Builder<static>|User whereEmailVerifiedAt($value)
 * @method static Builder<static>|User whereId($value)
 * @method static Builder<static>|User whereLocale($value)
 * @method static Builder<static>|User whereName($value)
 * @method static Builder<static>|User wherePassword($value)
 * @method static Builder<static>|User whereRememberToken($value)
 * @method static Builder<static>|User whereUpdatedAt($value)
 * @method static Builder<static>|User withoutPermission($permissions)
 * @method static Builder<static>|User withoutRole($roles, $guard = null)
 * @method static Builder<static>|User fosterHomes()
 * @method static Builder<static>|User handlers()
 * @mixin \Eloquent
 */
class User extends Authenticatable implements
    MustVerifyEmail,
    HasLocalePreference
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasUuids, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name', 'email', 'password', 'locale'];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = ['password', 'remember_token', 'pivot'];

    protected $dispatchesEvents = [
        'created' => UserCreated::class,
    ];

    public static function scopeHandlers(Builder $builder): void
    {
        $builder
            ->role([
                OrganisationRole::ANIMAL_HANDLER,
                OrganisationRole::ANIMAL_LEAD,
            ])
            ->select(['id', 'name']);
    }

    public static function scopeFosterHomes(Builder $builder): void
    {
        $builder->role([OrganisationRole::FOSTER_HOME])->select(['id', 'name']);
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
            'user_id',
            'tenant_id',
            'id',
        )
            ->using(Member::class)
            ->withTimestamps();
    }

    /**
     * Get the user's preferred locale.
     */
    public function preferredLocale(): string
    {
        return $this->locale;
    }

    /**
     * The animals that are assigned to the user.
     */
    public function animals(): BelongsToMany
    {
        return $this->belongsToMany(
            Animal::class,
            'animal_users',
            'user_id',
            'animal_id',
            'id',
        );
    }

    /**
     * Get the users' address.
     */
    public function address(): MorphOne
    {
        return $this->morphOne(Address::class, 'addressable');
    }

    public function scopeTenant(Builder $query)
    {
        $query->whereHas('tenants', function (Builder $query) {
            $query->where('organisations.id', tenant('id'));
        });
    }

    public function selfDisclosure(): HasOne
    {
        return $this->hasOne(UserSelfDisclosure::class);
    }

    /**
     * Get the invitation for the member.
     */
    public function invitations(): HasMany
    {
        return $this->hasMany(OrganisationInvitation::class);
    }

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
}
