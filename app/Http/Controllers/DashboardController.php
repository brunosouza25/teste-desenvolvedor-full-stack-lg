<?php

namespace App\Http\Controllers;

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
        $selectedLine = $request->input('linha');

        $availableLines = $this->productivityService->getAvailableLines();
        $metrics = $this->productivityService->getMetrics($selectedLine);

        return view('dashboard', compact('metrics', 'availableLines', 'selectedLine'));
    }
}
