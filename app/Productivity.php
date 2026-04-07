<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $product_id
 * @property int $produced_quantity
 * @property int $defects_quantity
 * @property string $production_date
 * @property-read \App\Product|null $product
 */
class Productivity extends Model
{
    protected $fillable = [
        'product_id',
        'produced_quantity',
        'defects_quantity',
        'production_date',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
