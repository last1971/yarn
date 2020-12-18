<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

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
