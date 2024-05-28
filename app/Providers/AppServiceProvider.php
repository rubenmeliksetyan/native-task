<?php

namespace App\Providers;

use App\Services\Interfaces\IStockHttpClient;
use App\Services\Interfaces\IStockService;
use App\Services\StockHttpClient;
use App\Services\StockService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(IStockService::class, StockService::class);
        $this->app->singleton(IStockHttpClient::class, StockHttpClient::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
