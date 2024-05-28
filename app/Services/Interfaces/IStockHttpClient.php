<?php

namespace App\Services\Interfaces;

interface IStockHttpClient
{
    public function __construct();
    public function get(string $endpoint, array $params = []): array;

}
