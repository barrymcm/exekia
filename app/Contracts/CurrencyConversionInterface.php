<?php

namespace App\Contracts;

interface CurrencyConversionInterface
{
    public function fromGbpToUsd(float $hourlyRate = 0.00): string;

    public function fromGbpToEur(float $hourlyRate = 0.00): string;

    public function fromEurToGbp(float $hourlyRate = 0.00): string;

    public function fromEurToUsd(float $hourlyRate = 0.00): string;

    public function fromUsdToGbp(float $hourlyRate = 0.00): string;

    public function fromUsdToEur(float $hourlyRate = 0.00): string;
}
