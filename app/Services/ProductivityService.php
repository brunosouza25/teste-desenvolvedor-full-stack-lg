<?php

namespace App\Services;

use App\Product;
use App\Productivity;
use Illuminate\Support\Collection;

class ProductivityService
{
    /**
     *
     * @param int|string|null $selectedProductId
     * @return Collection
     */
    public function getMetrics($selectedProductId = null)
    {
        $query = Productivity::with('product')
            ->whereYear('production_date', '=', '2026')
            ->whereMonth('production_date', '=', '1');

        if ($selectedProductId) {
            $query->where('product_id', '=', (string) $selectedProductId);
        }

        /** @var Collection $productivities */
        $productivities = $query->get();

        return $productivities->groupBy('product_id')->map(function ($group) {
            /** @var Collection $group */
            $firstItem = $group->first();

            $totalProduced = (int) $group->sum('produced_quantity');
            $totalDefects = (int) $group->sum('defects_quantity');

            $efficiency = $totalProduced > 0
                ? (($totalProduced - $totalDefects) / $totalProduced) * 100
                : 0;

            return (object) [
                'product_id'     => $firstItem->product_id,
                'product_name'   => $firstItem->product->name ?? 'N/A',
                'total_produced' => $totalProduced,
                'total_defects'  => $totalDefects,
                'efficiency'     => (float) $efficiency,
            ];
        })->values();
    }

    /**
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAvailableLines()
    {
        return Product::orderBy('name')->get();
    }
}
