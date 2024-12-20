<?php

namespace App\Models\SelfDisclosure;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 *
 *
 * @property-read User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserSelfDisclosure newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserSelfDisclosure newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserSelfDisclosure query()
 * @property int $id
 * @property bool $not_banned
 * @property bool $accepted_inaccuracy
 * @property bool $has_proof_of_identity
 * @property bool $everyone_agrees
 * @property string|null $notes
 * @property string $global_user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserSelfDisclosure whereAcceptedInaccuracy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserSelfDisclosure whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserSelfDisclosure whereEveryoneAgrees($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserSelfDisclosure whereGlobalUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserSelfDisclosure whereHasProofOfIdentity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserSelfDisclosure whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserSelfDisclosure whereNotBanned($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserSelfDisclosure whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserSelfDisclosure whereUpdatedAt($value)
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SelfDisclosure\AnimalSpecificDisclosure> $animalSpecificDisclosures
 * @property-read int|null $animal_specific_disclosures_count
 * @property-read \App\Models\SelfDisclosure\UserCareEligibility|null $userAnimals
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SelfDisclosure\UserExperience> $userExperiences
 * @property-read int|null $user_experiences_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SelfDisclosure\UserFamilyMember> $userFamilyMembers
 * @property-read int|null $user_family_members_count
 * @property-read \App\Models\SelfDisclosure\UserHome|null $userHome
 * @property-read \App\Models\SelfDisclosure\UserSpecialNeeds|null $userSpecialNeeds
 * @mixin \Eloquent
 */
class UserSelfDisclosure extends Model
{
    /**
     * The user the self disclosure belongs to
     *
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'global_user_id', 'global_id');
    }

    /**
     * The family members attached to the self disclosure
     */
    public function userFamilyMembers(): HasMany
    {
        return $this->hasMany(UserFamilyMember::class, 'self_disclosure_id');
    }

    /**
     * The user home attached to the self disclosure
     */
    public function userHome(): HasOne
    {
        return $this->hasOne(UserHome::class, 'self_disclosure_id');
    }

    /**
     * The user special needs attached to the self disclosure
     */
    public function userSpecialNeeds(): HasOne
    {
        return $this->hasOne(UserSpecialNeeds::class, 'self_disclosure_id');
    }

    /**
     * The user care eligibility attached to the self disclosure
     */
    public function userAnimals(): HasOne
    {
        return $this->hasOne(UserCareEligibility::class, 'self_disclosure_id');
    }

    /**
     * The animal specific disclosures attached to the self disclosure
     */
    public function animalSpecificDisclosures(): HasMany
    {
        return $this->hasMany(
            AnimalSpecificDisclosure::class,
            'self_disclosure_id',
        );
    }

    /**
     * The user experiences attached to the self disclosure
     */
    public function userExperiences(): HasMany
    {
        return $this->hasMany(UserExperience::class, 'self_disclosure_id');
    }

    /**
     * The user eligibility attached to the self disclosure
     */
    public function userCareEligibility(): HasOne
    {
        return $this->hasOne(UserCareEligibility::class, 'self_disclosure_id');
    }
}
