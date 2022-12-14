<?php

namespace App\Providers;

use App\Contracts\CurrencyConversionInterface;
use App\Services\ExternalCurrencyConversionService;
use App\Services\LocalCurrencyConversionService;
use Illuminate\Support\ServiceProvider;

class CurrencyConversionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind( CurrencyConversionInterface::class, function () {
            return new LocalCurrencyConversionService();
        });

        $this->app->bind(CurrencyConversionInterface::class, function () {
            return new ExternalCurrencyConversionService();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
