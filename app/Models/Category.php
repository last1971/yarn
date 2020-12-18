<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Str;
use Kalnoy\Nestedset\NodeTrait;

class Category extends Model
{
    use HasFactory, NodeTrait, Uuids;

    protected $fillable = ['name', 'picture_id', 'description', 'article_id'];

    protected $with = ['picture', 'pictures'];

    public function setNameAttribute(string $value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    public function picture(): BelongsTo
    {
        return $this->belongsTo(Picture::class, 'picture_id');
    }

    public function pictures(): MorphMany
    {
        return $this->morphMany(Picture::class, 'picturable');
    }
}
