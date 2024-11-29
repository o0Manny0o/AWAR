<?php

namespace App\Models;

use App\Traits\HasResourcePermissions;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * 
 *
 * @property string $id
 * @property string $name
 * @property string $type
 * @property string $status
 * @property string $user_role
 * @property bool $registered
 * @property string|null $street
 * @property string|null $post_code
 * @property string|null $city
 * @property string|null $country
 * @property string|null $subdomain
 * @property string $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\User $user
 * @property-read bool $is_complete
 * @property-read bool $is_locked
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganisationApplication newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganisationApplication newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganisationApplication query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganisationApplication whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganisationApplication whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganisationApplication whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganisationApplication whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganisationApplication whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganisationApplication wherePostCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganisationApplication whereRegistered($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganisationApplication whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganisationApplication whereStreet($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganisationApplication whereSubdomain($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganisationApplication whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganisationApplication whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganisationApplication whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganisationApplication whereUserRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganisationApplication onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganisationApplication whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganisationApplication withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OrganisationApplication withoutTrashed()
 * @property-read bool $can_be_deleted
 * @property-read bool $can_be_restored
 * @property-read bool $can_be_submitted
 * @property-read bool $can_be_updated
 * @property-read bool $can_be_viewed
 * @mixin \Eloquent
 */
class OrganisationApplication extends Model
{
    use HasUuids, SoftDeletes, HasResourcePermissions;

    protected $guarded = [];

    protected $appends = [
        'can_be_deleted',
        'can_be_restored',
        'can_be_viewed',
        'can_be_updated',
        'can_be_submitted',];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    /**
     * Determine if the application is complete.
     *
     * The application is considered complete when all the fields are filled in
     *
     * @return bool
     */
    public function isComplete(): bool
    {
        return isset($this->name) &&
            isset($this->type) &&
            isset($this->user_role) &&
            isset($this->registered) &&
            isset($this->street) &&
            isset($this->city) &&
            isset($this->post_code) &&
            isset($this->country) &&
            isset($this->subdomain);
    }

    /**
     * Determine if the application is locked.
     *
     * An application is considered locked when it has been submitted and is waiting for approval.
     * The application is considered locked when its status is one of the following:
     * - pending
     * - approved
     * - rejected
     * - created
     *
     * @return bool
     */
    public function isLocked()
    {
        return in_array($this->status, ['submitted', 'pending', 'approved', 'rejected', 'created']);
    }
}
