<?php

namespace App\Models;

use App\Traits\SlugFromName;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * App\Models\Product
 *
 * @property string $id
 * @property string $name
 * @property string $slug
 * @property string|null $description
 * @property string|null $picture_id
 * @property string|null $article_id
 * @property string|null $producer_id
 * @property string|null $category_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Category|null $category
 * @property-read \App\Models\Picture|null $picture
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Picture[] $pictures
 * @property-read int|null $pictures_count
 * @property-read \App\Models\Producer|null $producer
 * @method static \Illuminate\Database\Eloquent\Builder|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product query()
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereArticleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePictureId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereProducerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ParameterValue[] $parameterValues
 * @property-read int|null $parameter_values_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Price[] $prices
 * @property-read int|null $prices_count
 */
class Product extends Model
{
    use HasFactory, Uuids, SlugFromName;

    protected $fillable = ['name', 'description', 'article_id', 'picture_id', 'category_id', 'producer_id'];

    protected $with = [
        'picture',
        'pictures',
        'producer',
        'category',
        'prices',
        'parameterValues',
    ];

    public function picture(): BelongsTo
    {
        return $this->belongsTo(Picture::class);
    }

    public function pictures(): MorphMany
    {
        return $this->morphMany(Picture::class, 'picturable');
    }

    public function producer(): BelongsTo
    {
        return $this->belongsTo(Producer::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function prices()
    {
        return $this->hasMany(Price::class)->orderBy('min');
    }

    public function parameterValues(): HasMany
    {
        return $this
            ->hasMany(ParameterValue::class)
            ->join('parameter_names', 'parameter_names.id', '=', 'parameter_name_id')
            ->orderBy('parameter_names.name')
            ->select('parameter_values.*');
    }
}
