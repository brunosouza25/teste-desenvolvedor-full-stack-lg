<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name'];

    public function productivities()
    {
        return $this->hasMany(Productivity::class);
    }
}
