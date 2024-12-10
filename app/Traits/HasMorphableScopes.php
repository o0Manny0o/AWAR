<?php

namespace App\Traits;

use App\Models\Animal\Cat;
use App\Models\Animal\Dog;
use Illuminate\Database\Eloquent\Builder;

trait HasMorphableScopes
{
    protected static string $_morphTypeColumn = 'animalable_type';

    public static function column()
    {
        return static::$morphTypeColumn ?? static::$_morphTypeColumn;
    }

    /**
     * Returns all the dog families
     */
    public static function scopeDogs(Builder $builder): void
    {
        $builder->where(self::column(), Dog::class);
    }

    /**
     * Returns all the cat families
     */
    public static function scopeCats(Builder $builder): void
    {
        $builder->where(self::column(), Cat::class);
    }

    /**
     * Returns all the cat families
     */
    public static function scopeSubtype(Builder $builder, string $type): void
    {
        $builder->where(self::column(), $type);
    }
}
