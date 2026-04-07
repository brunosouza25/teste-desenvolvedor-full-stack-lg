<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Productivity extends Model
{
    protected $fillable = ['product_id', 'produced_quantity', 'defects_quantity', 'production_date'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

}
