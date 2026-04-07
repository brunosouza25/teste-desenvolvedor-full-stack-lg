<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ProductivityService;

class DashboardController extends Controller
{
    protected $productivityService;

    public function __construct(ProductivityService $productivityService)
    {
        $this->productivityService = $productivityService;
    }

    public function index(Request $request)
    {
        $selectedLine = $request->input('linha_id');

        $metrics = $this->productivityService->getMetrics($selectedLine);
        $availableLines = $this->productivityService->getAvailableLines();

        return response()->json([
            'metrics' => $metrics,
            'availableLines' => $availableLines
        ]);
    }
}
