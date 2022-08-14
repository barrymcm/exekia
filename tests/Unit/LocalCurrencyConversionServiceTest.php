<?php

namespace Tests\Unit;

use App\Services\LocalCurrencyConversionService;
use Tests\TestCase;

/**
 * @coversDefaultClass \App\Services\LocalCurrencyConversionService
 */
class LocalCurrencyConversionServiceTest extends TestCase
{
    private LocalCurrencyConversionService $localCurrencyConversionService;

    public function setUp(): void
    {
        parent::setUp();
        $this->localCurrencyConversionService = new LocalCurrencyConversionService();
    }

    public function testHourlyRatesAreConvertedFromEurToGbp(): void
    {
        $actual = $this->localCurrencyConversionService->convertHourlyRateToCurrency(
            1.55,
         'EUR',
         'GBP'
        );

        $expected = $this->localCurrencyConversionService->fromEurToGbp(1.55);
        $this->assertEquals($expected, $actual);
    }
}
