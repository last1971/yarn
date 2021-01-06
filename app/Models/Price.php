<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Price
 *
 * @property string $id
 * @property int $min
 * @property float $price
 * @property string $product_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static Builder|Price newModelQuery()
 * @method static Builder|Price newQuery()
 * @method static Builder|Price query()
 * @method static Builder|Price whereCreatedAt($value)
 * @method static Builder|Price whereId($value)
 * @method static Builder|Price whereMin($value)
 * @method static Builder|Price wherePrice($value)
 * @method static Builder|Price whereProductId($value)
 * @method static Builder|Price whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Price extends Model
{
    use HasFactory, Uuids;

    protected $fillable = ['min', 'price', 'product_id'];

}
