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
    private ApiInterface $api;

    /**
     * ConverterService constructor.
     * @param ApiInterface $api
     */
    public function __construct(ApiInterface $api)
    {
        $this->api = $api;
    }

    /**
     * Convert the amount be taking the exchange rates data from the api
     *
     * @param float $amount
     * @param string $currency
     *
     * @return float
     */
    public function convert(float $amount, string $currency, $commissionValue): float
    {
        $rates = $this->api->handleApiData()->rates;

        foreach ($rates as $rate => $value) {
            if ($rate === $currency) {
                $this->convertedAmount = ($amount * $value * $commissionValue) / 100;
            }
        }

        return round($this->convertedAmount, 2);
    }
}