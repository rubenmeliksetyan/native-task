<?php

namespace App\Http\Controllers;

use App\Services\StockService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class StockController extends Controller
{
    protected $stockService;

    public function __construct(StockService $stockService) {
        $this->stockService = $stockService;
    }
    public function index()
    {
        try {
            $stocks = $this->stockService->getStockData();
            return response()->json($stocks);
        } catch (\Exception $e) {
            Log::error('Error fetching stock data', ['message' => $e->getMessage()]);
            return response()->json(['error' => 'Unable to fetch stock data at this time. Please try again later.'], 500);
        }
    }
}
