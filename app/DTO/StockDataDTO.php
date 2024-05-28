<?php

namespace App\DTO;

class StockDataDTO
{
    public string $fullExchangeName;
    public string $symbol;
    public string $latestClose;
    public string $previousClose;
    public string $priceChange;

    public function __construct(string $fullExchangeName, string $symbol, float $latestClose, float $previousClose)
    {
        $this->fullExchangeName = $fullExchangeName;
        $this->symbol = $symbol;
        $this->latestClose = $this->formatPrice($latestClose);
        $this->previousClose = $this->formatPrice($previousClose);
        $this->priceChange = $this->formatPrice($latestClose - $previousClose);
    }

    private function formatPrice(float $price): string
    {
        return number_format($price, 2, '.', ',');
    }
}
