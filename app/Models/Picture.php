<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * App\Models\Picture
 *
 * @property string $id
 * @property string $file
 * @property string $picturable_id
 * @property string $picturable_type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Model|\Eloquent $picturable
 * @method static \Illuminate\Database\Eloquent\Builder|Picture newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Picture newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Picture query()
 * @method static \Illuminate\Database\Eloquent\Builder|Picture whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Picture whereFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Picture whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Picture wherePicturableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Picture wherePicturableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Picture whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Picture extends Model
{
    use HasFactory, Uuids;

    protected $fillable = ['file', 'picturable_id', 'picturable_type'];
    /**
     * @return MorphTo
     */
    public function picturable(): MorphTo
    {
        return $this->morphTo();
    }
}
