<?php

declare(strict_types=1);

namespace App\Providers;

use App\Entity\ConversionRate;

class ConversionRateProvider
{
    /**
     * @var ConversionRate[]
     */
    private array $conversionRates = [];


    /**
     * @param string $currencyFrom
     * @param string $currencyTo
     * @return string
     */
    public function provideConversionRate(string $currencyFrom, string $currencyTo): string
    {
        /** @var ConversionRate $rate */
        foreach ($this->getConversionRates() as $rate) {
            if ($rate->getCurrencyFrom() === $currencyFrom && $rate->getCurrencyTo() === $currencyTo) {
                return $rate->getRate();
            }
        }
    }

    /**
     * @return ConversionRate[]
     */
    public function getConversionRates(): array
    {
        return $this->conversionRates = [
            (new ConversionRate())
                ->setCurrencyFrom('EUR')
                ->setCurrencyTo('JPY')
                ->setRate('129.53'),
            (new ConversionRate())
                ->setCurrencyFrom('JPY')
                ->setCurrencyTo('EUR')
                ->setRate('0.00772'),
            (new ConversionRate())
                ->setCurrencyFrom('EUR')
                ->setCurrencyTo('USD')
                ->setRate('1.1497'),
            (new ConversionRate())
                ->setCurrencyFrom('USD')
                ->setCurrencyTo('EUR')
                ->setRate('0.83'),
            (new ConversionRate())
                ->setCurrencyFrom('JPY')
                ->setCurrencyTo('USD')
                ->setRate('0.0091'),
            (new ConversionRate())
                ->setCurrencyFrom('USD')
                ->setCurrencyTo('JPY')
                ->setRate('109.58'),
        ];
    }


}
