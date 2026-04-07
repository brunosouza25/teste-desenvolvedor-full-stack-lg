<?php

use App\Product;
use App\Productivity;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ProductivitySeeder extends Seeder
{
    public function run()
    {
        $products = Product::all();
        $startDate = Carbon::create(2026, 1, 1);

        for ($i = 0; $i < 31; $i++) {
            foreach ($products as $product) {
                $produced = rand(100, 500);

                $isBadDay = ($i % 5 == 0 || rand(1, 10) > 8);

                if ($isBadDay) {
                    $defectPercentage = rand(6, 15) / 100;
                } else {
                    $defectPercentage = rand(0, 4) / 100;
                }

                $defects = (int) ($produced * $defectPercentage);

                Productivity::create([
                    'product_id'       => $product->id,
                    'produced_quantity' => $produced,
                    'defects_quantity'  => $defects,
                    'production_date'   => $startDate->copy()->addDays($i)->format('Y-m-d'),
                ]);
            }
        }
    }
}
