<?php

namespace App\Services;

use App\Services\Interfaces\IStockHttpClient;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class StockHttpClient implements IStockHttpClient
{
    protected string $baseUrl;
    protected string $apiKey;
    protected PendingRequest $http;

    public function __construct()
    {
        $this->baseUrl = config('rapid.rapidApiUrl');
        $this->apiKey = config('rapid.rapidApiKey');
        $this->http = Http::withHeaders([
            'x-rapidapi-key' => $this->apiKey,
            'x-rapidapi-host' => parse_url($this->baseUrl, PHP_URL_HOST)
        ]);
    }

    public function get(string $endpoint, array $params = []): array
    {
        try {
            $response = $this->http->get($this->baseUrl . $endpoint, $params);
            $response->throw();
            return $response->json();
        } catch (RequestException $e) {
            dd($e->getMessage());
            Log::error('Failed to get stock data', ['message' => $e->getMessage()]);
            return [];
        }
    }
}
