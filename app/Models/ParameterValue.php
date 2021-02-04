<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Builder;
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
 * @property-read ParameterName $parameterName
 * @property-read \App\Models\ParameterUnit|null $parameterUnit
 * @property-read \App\Models\Product $product
 * @method static Builder|ParameterValue newModelQuery()
 * @method static Builder|ParameterValue newQuery()
 * @method static Builder|ParameterValue query()
 * @method static Builder|ParameterValue whereCreatedAt($value)
 * @method static Builder|ParameterValue whereFraction($value)
 * @method static Builder|ParameterValue whereId($value)
 * @method static Builder|ParameterValue whereNumericValue($value)
 * @method static Builder|ParameterValue whereParameterNameId($value)
 * @method static Builder|ParameterValue whereParameterUnitId($value)
 * @method static Builder|ParameterValue whereProductId($value)
 * @method static Builder|ParameterValue whereStringValue($value)
 * @method static Builder|ParameterValue whereUpdatedAt($value)
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
