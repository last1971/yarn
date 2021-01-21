<?php

namespace App\Models;

use App\Traits\SlugFromName;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WarehouseBalance extends Model
{
    use HasFactory, Uuids, SlugFromName;

    protected $fillable = ['balance', 'warehouse_id', 'product_id'];

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
