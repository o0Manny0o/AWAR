<?php

namespace App\Models\Animal;

use Illuminate\Database\Eloquent\Model;

/**
 *
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AnimalChange newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AnimalChange newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AnimalChange query()
 * @property int $id
 * @property string $field
 * @property string $value
 * @property int $animal_history_id
 * @property string $created_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AnimalChange whereAnimalHistoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AnimalChange whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AnimalChange whereField($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AnimalChange whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AnimalChange whereValue($value)
 * @mixin \Eloquent
 */
class AnimalChange extends Model
{
    protected $fillable = ['field', 'value'];

    public $timestamps = false;
}
