<?php

namespace App\Services;

use App\Productivity;
use App\Product;
use Illuminate\Support\Facades\DB;

class ProductivityService
{
    public function getMetrics($selectedProductId = null)
    {
        $query = Productivity::with('product')
            ->whereYear('production_date', 2026)
            ->whereMonth('production_date', 1);

        if ($selectedProductId) {
            $query->where('product_id', $selectedProductId);
        }

        $metrics = $query->selectRaw('
                product_id,
                SUM(produced_quantity) as total_produced,
                SUM(defects_quantity) as total_defects
            ')
            ->groupBy('product_id')
            ->get();

        return $metrics->map(function ($item) {
            $efficiency = $item->total_produced > 0 ? (($item->total_produced - $item->total_defects) / $item->total_produced) * 100 : 0; //calculo de eficiência
            $item->efficiency = $efficiency;
            $item->product_name = $item->product->name;

            return $item;
        });
    }

    public function getAvailableLines()
    {
        return Product::orderBy('name')->get();
    }
}
