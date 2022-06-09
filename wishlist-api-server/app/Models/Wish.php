<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Wish
 *
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Wish newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Wish newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Wish query()
 * @method static \Illuminate\Database\Eloquent\Builder|Wish whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Wish whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Wish whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Wish whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Wish whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Wish whereUserId($value)
 * @mixin \Eloquent
 * @property float $percentage_of_implementation
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Wish whereIsCameTrue($value)
 * @property int $is_archived
 * @method static \Illuminate\Database\Eloquent\Builder|Wish whereIsArchived($value)
 */
class Wish extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'percentage_of_implementation',
        'is_archived'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
