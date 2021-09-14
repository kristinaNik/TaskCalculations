<?php

declare(strict_types=1);

namespace App\Services;

use App\Providers\ConversionRateProvider;

use Evp\Component\Money\Money;

class CurrencyConverter
{
    private ConversionRateProvider $conversionRateProvider;

    public function __construct(ConversionRateProvider $conversionRateProvider)
    {
        $this->conversionRateProvider = $conversionRateProvider;
    }

    public function convert(Money $amount, string $currencyTo): Money
    {
        if ($amount->getCurrency() === $currencyTo) {
            return clone $amount;
        }

        $rate = $this->conversionRateProvider->provideConversionRate($amount->getCurrency(), $currencyTo);

        return $amount->mul($rate)->setCurrency($currencyTo);
    }
}
