<?php

namespace Tests\Unit;

use App\DTO\StockDataDTO;
use App\Services\StockHttpClient;
use App\Services\StockService;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Collection;
use Mockery;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Psr7\Response as GuzzleResponse;

class StockServiceTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_getStockData_returns_collection_of_stock_data_dto()
    {
        $mockHttpClient = Mockery::mock(StockHttpClient::class);
        $mockHttpClient->shouldReceive('get')
            ->once()
            ->with('/market/v2/get-summary', ['region' => 'US'])
            ->andReturn($this->mockApiResponse());

        $stockService = new StockService($mockHttpClient);
        $result = $stockService->getStockData();

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertCount(1, $result);
        $this->assertInstanceOf(StockDataDTO::class, $result->first());

        $dto = $result->first();
        $this->assertEquals('Dow Jones Industrial Average', $dto->fullExchangeName);
        $this->assertEquals('DJI', $dto->symbol);
        $this->assertEquals('34,000.00', $dto->latestClose);
        $this->assertEquals('33,500.00', $dto->previousClose);
        $this->assertEquals('500.00', $dto->priceChange);
    }

    public function test_getStockData_handles_request_exception()
    {
        $mockHttpClient = Mockery::mock(StockHttpClient::class);
        $mockHttpClient->shouldReceive('get')
            ->once()
            ->with('/market/v2/get-summary', ['region' => 'US'])
            ->andThrow(new RequestException(new Response(new GuzzleResponse(500))));

        $stockService = new StockService($mockHttpClient);

        $this->expectException(RequestException::class);

        $stockService->getStockData();
    }

    private function mockApiResponse(): array
    {
        return [
            'marketSummaryAndSparkResponse' => [
                'result' => [
                    [
                        'fullExchangeName' => 'Dow Jones Industrial Average',
                        'symbol' => 'DJI',
                        'spark' => [
                            'close' => [33500.00, 34000.00],
                            'previousClose' => 33500.00
                        ]
                    ]
                ]
            ]
        ];
    }
}
