<?php

namespace App\Models\Animal;

/**
 *
 *
 * @property-read \App\Models\Animal\Animal|null $animal
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Dog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Dog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Dog query()
 * @property int $id
 * @property string $breed
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Dog whereBreed($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Dog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Dog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Dog whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Dog extends Animalable
{
    protected $fillable = ['breed'];
    protected $hidden = ['id'];
    protected array $tracked = ['breed'];
}
