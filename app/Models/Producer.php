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
 * App\Models\Producer
 *
 * @property string $id
 * @property string $name
 * @property string|null $description
 * @property string $slug
 * @property string|null $picture_id
 * @property string|null $article_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Picture|null $picture
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Picture[] $pictures
 * @property-read int|null $pictures_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product[] $products
 * @property-read int|null $products_count
 * @method static \Illuminate\Database\Eloquent\Builder|Producer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Producer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Producer query()
 * @method static \Illuminate\Database\Eloquent\Builder|Producer whereArticleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Producer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Producer whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Producer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Producer whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Producer wherePictureId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Producer whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Producer whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string|null $site
 * @method static \Illuminate\Database\Eloquent\Builder|Producer whereSite($value)
 */
class Producer extends Model
{
    use HasFactory, Uuids, SlugFromName;

    protected $fillable = ['name', 'site', 'description', 'article_id', 'picture_id'];

    protected $with = ['picture', 'pictures'];

    public function picture(): BelongsTo
    {
        return $this->belongsTo(Picture::class, 'picture_id');
    }

    public function pictures(): MorphMany
    {
        return $this->morphMany(Picture::class, 'picturable');
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
