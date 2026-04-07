<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Productivity;
use App\Product;
use Faker\Generator as Faker;

$factory->define(Productivity::class, function (Faker $faker) {
    return [
        'product_id' => factory(Product::class),
        'produced_quantity' => $faker->numberBetween(100, 500),
        'defects_quantity' => $faker->numberBetween(0, 50),
        'production_date' => '2026-01-15',
    ];
});
