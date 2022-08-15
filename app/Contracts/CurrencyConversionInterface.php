<?php

namespace App\Contracts;

interface CurrencyConversionInterface
{
    public function convertHourlyRateToCurrency(float $hourlyRate, string $usersCurrency, string $convertToCurrency): string;
}
