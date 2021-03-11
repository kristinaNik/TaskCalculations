<?php
namespace App\Services;

use App\Interfaces\ApiInterface;
use App\Interfaces\ConvertInterface;

class ConverterService implements ConvertInterface
{
    /**
     * @var float
     */
    private float $convertedAmount;

    /**
     * @var ApiInterface
     */
    private $rates;

    /**
     * ConverterService constructor.
     * @param RatesService $rates
     */
    public function __construct(RatesService $rates)
    {
        $this->rates = $rates;
    }

    /**
     * Convert the amount be taking the exchange rates data from the api
     *
     * @param float $amount
     * @param string $currency
     *
     * @return float
     */
    public function convert(float $amount, string $currency): float
    {
        $rates = $this->rates->getRates();

        foreach ($rates as $rate => $value) {
            if ($rate === $currency) {
                $this->convertedAmount = $amount / $value;
            }
        }

        return round($this->convertedAmount, 2);
    }
}