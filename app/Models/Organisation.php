<?php

namespace App\Models;

use App\Models\Animal\Animal;
use App\Models\Tenant\Member;
use App\Models\Tenant\OrganisationLocation;
use App\Models\Tenant\OrganisationPublicSettings;
use App\Traits\OptionalAppends;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Facades\Config;
use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;
use Stancl\Tenancy\Database\Models\Tenant;
use Stancl\Tenancy\Database\Models\TenantPivot;

/**
 *
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property array|null $data
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Domain> $domains
 * @property-read int|null $domains_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Stancl\Tenancy\Database\TenantCollection<int, static> all($columns = ['*'])
 * @method static \Stancl\Tenancy\Database\TenantCollection<int, static> get($columns = ['*'])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organisation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organisation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organisation query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organisation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organisation whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organisation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organisation whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organisation whereUpdatedAt($value)
 * @property-read TenantPivot|null $pivot
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $members
 * @property-read int|null $members_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Animal> $animals
 * @property-read int|null $animals_count
 * @property-read mixed $dashboard_url
 * @property-read \Illuminate\Database\Eloquent\Collection<int, OrganisationLocation> $locations
 * @property-read int|null $locations_count
 * @property-read OrganisationPublicSettings|null $publicSettings
 * @mixin \Eloquent
 */
class Organisation extends Tenant implements TenantWithDatabase
{
    use HasDatabase, HasDomains, HasUuids, OptionalAppends;

    protected $table = 'organisations';

    protected $fillable = ['name'];

    protected $hidden = ['pivot', 'data', 'tenancy_db_name', 'id'];

    protected $appends = ['dashboard_url'];

    public static function getCustomColumns(): array
    {
        return ['id', 'name'];
    }

    public function getIncrementing(): bool
    {
        return true;
    }

    /**
     * Get all the dashboard url for the organisation.
     */
    public function getDashboardUrlAttribute()
    {
        return tenant_route(
            $this->domains->first()?->domain ?? '',
            'tenant.dashboard',
        );
    }

    /**
     * Get all the organisation domains.
     */
    public function domains(): HasMany
    {
        return $this->hasMany(
            config('tenancy.domain_model'),
            'organisation_id',
        );
    }

    /**
     * Get all the organisation members.
     */
    public function members(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'organisation_users',
            'tenant_id',
            'user_id',
            'id',
            'id',
        )
            ->using(Member::class)
            ->withTimestamps();
    }
    /**
     * Get all the organisation animals.
     */
    public function animals(): HasMany
    {
        return $this->hasMany(Animal::class);
    }

    /**
     * Get all the organisation locations.
     */
    public function locations(): HasMany
    {
        return $this->hasMany(OrganisationLocation::class);
    }

    /**
     * Get the organisation public settings.
     */
    public function publicSettings(): HasOne
    {
        return $this->hasOne(OrganisationPublicSettings::class);
    }
}
