<?php

use App\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $lines = ['Geladeira', 'Máquina de Lavar', 'TV', 'Ar-Condicionado'];

        foreach ($lines as $line) {
            Product::create(['name' => $line]);
        }
    }
}
