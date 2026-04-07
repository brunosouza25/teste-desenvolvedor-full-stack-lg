<?php

use Illuminate\Database\Seeder;
use App\Productivity;
use App\Product;
use Carbon\Carbon;

class ProductivitySeeder extends Seeder
{
    public function run()
    {
        $products = Product::all();
        $startDate = Carbon::create(2026, 1, 1); //data de inicio

        for ($i = 0; $i < 31; $i++) {
            foreach ($products as $product) {
                $produced = rand(100, 500);
                Productivity::create([
                    'product_id' => $product->id,
                    'produced_quantity' => $produced,
                    'defects_quantity' => rand(0, $produced * 0.1), // randomico para a quantidade de defeitos com no máximo 10% da quantidade produzida
                    'production_date' => $startDate->copy()->addDays($i)->format('Y-m-d'),
                ]);
            }
        }
    }
}
