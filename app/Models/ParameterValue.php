<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\ParameterValue
 *
 * @property string $id
 * @property string $parameter_name_id
 * @property string|null $numeric_value
 * @property int|null $fraction
 * @property string|null $string_value
 * @property string|null $parameter_unit_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $product_id
 * @property-read \App\Models\ParameterName $parameterName
 * @property-read \App\Models\ParameterUnit|null $parameterUnit
 * @property-read \App\Models\Product $product
 * @method static \Illuminate\Database\Eloquent\Builder|ParameterValue newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ParameterValue newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ParameterValue query()
 * @method static \Illuminate\Database\Eloquent\Builder|ParameterValue whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParameterValue whereFraction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParameterValue whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParameterValue whereNumericValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParameterValue whereParameterNameId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParameterValue whereParameterUnitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParameterValue whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParameterValue whereStringValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParameterValue whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ParameterValue extends Model
{
    use HasFactory, Uuids;

    protected $fillable = [
        'product_id',
        'parameter_name_id',
        'parameter_unit_id',
        'numeric_value',
        'fraction',
        'string_value'
    ];

    protected $with = ['parameterName', 'parameterUnit'];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function parameterName(): BelongsTo
    {
        return $this->belongsTo(ParameterName::class);
    }

    public function parameterUnit(): BelongsTo
    {
        return $this->belongsTo(ParameterUnit::class);
    }
}
