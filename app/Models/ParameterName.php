<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\ParameterName
 *
 * @property string $id
 * @property string $name
 * @property string $type
 * @property string|null $parameter_unit_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\ParameterUnit|null $parameterUnit
 * @method static \Illuminate\Database\Eloquent\Builder|ParameterName newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ParameterName newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ParameterName query()
 * @method static \Illuminate\Database\Eloquent\Builder|ParameterName whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParameterName whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParameterName whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParameterName whereParameterUnitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParameterName whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParameterName whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ParameterName extends Model
{
    use HasFactory, Uuids;

    protected $fillable = ['name', 'type', 'parameter_unit_id'];

    public function parameterUnit(): BelongsTo
    {
        return $this->belongsTo(ParameterUnit::class);
    }
}
