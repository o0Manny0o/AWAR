<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;
use Stancl\Tenancy\Database\Models\Tenant;

class Organisation extends Tenant implements TenantWithDatabase
{

    use HasDatabase, HasDomains;

    protected $table = 'organisations';

    protected $fillable = [
        'name',
    ];

    public static function getCustomColumns(): array
    {
        return [
            'id',
            'name'
        ];
    }

    public function getIncrementing(): bool
    {
        return true;
    }

    public function domains(): HasMany
    {
        return $this->hasMany(config('tenancy.domain_model'), 'organisation_id');
    }


    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'organisation_user', 'organisation_id', 'user_id')
            ->withTimestamps();
    }
}
