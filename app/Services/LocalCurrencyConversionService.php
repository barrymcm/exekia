<?php

namespace App\Services;

use App\Contracts\CurrencyConversionInterface;
use App\Models\ExchangeRate;

class LocalCurrencyConversionService implements CurrencyConversionInterface
{
    public function convertHourlyRateToCurrency(float $hourlyRate, string $usersCurrency, string $convertToCurrency): string
    {
        return round($hourlyRate * ExchangeRate::where('currency_exchange', (string) $usersCurrency. '–' .(string) $convertToCurrency)->first()->rate, 2);
    }
}
