<?php

namespace App\Services;

use App\Contracts\CurrencyConversionInterface;
use App\Models\ExchangeRate;

class LocalCurrencyConvertionService implements CurrencyConversionInterface
{
    public function convertHourlyRateToCurrency(
        float $hourlyRate,
        string $usersCurrency,
        string $convertToCurrency
    ): string
    {
        if($usersCurrency === 'GBP' && $convertToCurrency === 'USD') {
            return $this->fromGbpToUsd($hourlyRate);
        }

        if($usersCurrency === 'GBP' && $convertToCurrency === 'EUR') {
            return $this->fromGbpToEur($hourlyRate);
        }

        if($usersCurrency === 'EUR' && $convertToCurrency === 'GBP') {
            return $this->fromEurToGbp($hourlyRate);
        }

        if($usersCurrency === 'EUR' && $convertToCurrency === 'USD') {
            return $this->fromEurToUsd($hourlyRate);
        }

        if($usersCurrency === 'USD' && $convertToCurrency === 'GBP') {
            return $this->fromUsdToGbp($hourlyRate);
        }

        if($usersCurrency === 'USD' && $convertToCurrency === 'EUR') {
            return $this->fromUsdToEur($hourlyRate);
        }

        return 'Conversion not available';
    }

    public function fromGbpToUsd(float $hourlyRate = 0.00): string
    {
        return round($hourlyRate * ExchangeRate::where('currency_exchange', 'GBP–USD')->first()->rate, 2);
    }

    public function fromGbpToEur(float $hourlyRate = 0.00): string
    {
        return round($hourlyRate * ExchangeRate::where('currency_exchange', 'GBP–EUR')->first()->rate, 2);
    }

    public function fromEurToGbp(float $hourlyRate = 0.00): string
    {
        return round($hourlyRate * ExchangeRate::where('currency_exchange', 'EUR–GBP')->first()->rate, 2);
    }

    public function fromEurToUsd(float $hourlyRate = 0.00): string
    {
        return round($hourlyRate * ExchangeRate::where('currency_exchange', 'EUR–USD')->first()->rate, 2);
    }

    public function fromUsdToGbp(float $hourlyRate = 0.00): string
    {
        return round($hourlyRate * ExchangeRate::where('currency_exchange', 'USD–GBP')->first()->rate, 2);
    }

    public function fromUsdToEur(float $hourlyRate = 0.00): string
    {
        return round($hourlyRate * ExchangeRate::where('currency_exchange', 'USD–EUR')->first()->rate, 2);
    }
}
