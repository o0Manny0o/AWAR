<?php

namespace App\Models;

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
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
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
 * @mixin \Eloquent
 */
class OrganisationApplication extends Model
{
    use HasUuids, SoftDeletes;

    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function currentStep()
    {
        if (!isset($this->name) || !isset($this->type) || !isset($this->user_role) || !isset($this->registered)) {
            return 1;
        } elseif (!isset($this->street) || !isset($this->city) || !isset($this->post_code) || !isset($this->country)) {
            return 2;
        } elseif (!isset($this->subdomain)) {
            return 3;
        } else {
            return 1;
        }
    }
}
