<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\ParameterUnit
 *
 * @property string $id
 * @property string $name
 * @property string $abbreviation
 * @property int $coefficient
 * @property int $multiply
 * @property string|null $parameter_unit_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ParameterName[] $parameterNames
 * @property-read int|null $parameter_names_count
 * @property-read ParameterUnit|null $parameterUnit
 * @property-read \Illuminate\Database\Eloquent\Collection|ParameterUnit[] $parameterUnits
 * @property-read int|null $parameter_units_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ParameterValue[] $parameterValues
 * @property-read int|null $parameter_values_count
 * @method static \Illuminate\Database\Eloquent\Builder|ParameterUnit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ParameterUnit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ParameterUnit query()
 * @method static \Illuminate\Database\Eloquent\Builder|ParameterUnit whereAbbreviation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParameterUnit whereCoefficient($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParameterUnit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParameterUnit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParameterUnit whereMultiply($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParameterUnit whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParameterUnit whereParameterUnitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParameterUnit whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ParameterUnit extends Model
{
    use HasFactory, Uuids;

    protected $fillable = ['name', 'abbreviation', 'coefficient', 'multiply', 'parameter_unit_id'];

    public function parameterUnit(): BelongsTo
    {
        return $this->belongsTo(ParameterUnit::class);
    }

    public function parameterUnits(): HasMany
    {
        return $this->hasMany(ParameterUnit::class);
    }

    public function parameterNames(): HasMany
    {
        return $this->hasMany(ParameterName::class);
    }

    public function parameterValues(): HasMany
    {
        return $this->hasMany(ParameterValue::class);
    }
}
