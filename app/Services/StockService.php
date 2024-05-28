<?php

namespace App\Services;

use App\DTO\StockDataDTO;
use App\Services\Interfaces\IStockHttpClient;
use App\Services\Interfaces\IStockService;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class StockService implements IStockService
{
    protected IStockHttpClient $client;

    public function __construct(IStockHttpClient $client)
    {
        $this->client = $client;
    }
    public function getStockData(): Collection
    {
        $response = $this->client->get('market/v2/get-summary', [
            'region' => 'US'
        ]);
        return $this->processStockData($response);
    }

    private function processStockData(array $data): Collection
    {
        $stocks = collect();

        foreach ($data['marketSummaryAndSparkResponse']['result'] as $stock) {
            $latestClose = end($stock['spark']['close']);
            $previousClose = $stock['spark']['previousClose'];

            $stocks->push(new StockDataDTO(
                $stock['fullExchangeName'],
                $stock['symbol'],
                $latestClose,
                $previousClose
            ));
        }
        return $stocks;
    }
}
