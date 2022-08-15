<?php

namespace App\Services;

use App\Contracts\CurrencyConversionInterface;
use Illuminate\Support\Facades\Http;

class ExternalCurrencyConversionService implements CurrencyConversionInterface
{
    private const EXTERNAL_API_EXCHANGE_RATES = "https://api.apilayer.com/exchangerates_data/latest?";

    public function convertHourlyRateToCurrency(
        float $hourlyRate,
        string $usersCurrency,
        string $convertToCurrency,
    ): string
    {
        $response = Http::withHeaders($this->headers())
            ->retry(3, 150)
            ->get(self::EXTERNAL_API_EXCHANGE_RATES . "to=$convertToCurrency&from=$usersCurrency&amount=" . $hourlyRate);

        $body = $response->json();

        $response->throwIf($response->clientError());
        $response->throwIf($response->serverError());

        return round($hourlyRate * $body['rates'][$convertToCurrency], 2);

    }

    private function headers(): array
    {
        return [
            "Content-Type" => "text/plain",
            "apikey" => env('API_LAYER_KEY')
        ];
    }
}
