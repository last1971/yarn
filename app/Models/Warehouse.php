<?php

namespace App\Models;

use App\Traits\SlugFromName;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    use HasFactory, Uuids, SlugFromName;

    protected $fillable = ['name', 'supplier_id'];

    protected $with = ['supplier:id,name'];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
