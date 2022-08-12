<?php

namespace App\Services;

use App\Contracts\CurrencyConversionInterface;
use Illuminate\Support\Facades\Http;

class ExternalCurrencyConversionService implements CurrencyConversionInterface
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

        if($usersCurrency === $convertToCurrency) {
            return $hourlyRate;
        }

        return 'Conversion not available';
    }

    public function fromGbpToUsd(float $hourlyRate = 0.00): string
    {
        $response = Http::withHeaders($this->headers())
            ->retry(3, 150)
            ->get("https://api.apilayer.com/exchangerates_data/latest?to=USD&from=GBP&amount=" . $hourlyRate);

        $body = $response->json();

        return round($hourlyRate * $body['rates']['USD'], 2);

    }

    public function fromGbpToEur(float $hourlyRate = 0.00): string
    {
        $response = Http::withHeaders($this->headers())
            ->retry(3, 150)
            ->get("https://api.apilayer.com/exchangerates_data/latest?to=EUR&from=GBP&amount=" . $hourlyRate);

        $body = $response->json();

        return round($hourlyRate * $body['rates']['EUR'], 2);
    }

    public function fromEurToGbp(float $hourlyRate = 0.00): string
    {
        $response = Http::withHeaders($this->headers())
            ->get("https://api.apilayer.com/exchangerates_data/latest?to=GBP&from=EUR&amount=" . $hourlyRate);

        $body = $response->json();

        return round($hourlyRate * $body['rates']['GBP'], 2);
    }

    public function fromEurToUsd(float $hourlyRate = 0.00): string
    {
        $response = Http::withHeaders($this->headers())
            ->retry(3, 150)
            ->get("https://api.apilayer.com/exchangerates_data/latest?to=EUR&from=USD&amount=" . $hourlyRate);

        $body = $response->json();

        return round($hourlyRate * $body['rates']['USD'], 2);
    }

    public function fromUsdToGbp(float $hourlyRate = 0.00): string
    {
        $response = Http::withHeaders($this->headers())
            ->retry(3, 150)
            ->get("https://api.apilayer.com/exchangerates_data/latest?to=USD&from=GBP&amount=" . $hourlyRate);

        $body = $response->json();

        return round($hourlyRate * $body['rates']['GBP'], 2);
    }

    public function fromUsdToEur(float $hourlyRate = 0.00): string
    {
        $response = Http::withHeaders($this->headers())
            ->acceptJson()
            ->retry(3, 150)
            ->get("https://api.apilayer.com/exchangerates_data/latest?to=USD&from=EUR&amount=" . $hourlyRate);

        $body = $response->json();

        return round($hourlyRate * $body['rates']['EUR'], 2);
    }

    private function headers(): array
    {
        return [
            "Content-Type" => "text/plain",
            "apikey" => env('API_LAYER_KEY')
        ];
    }
}
