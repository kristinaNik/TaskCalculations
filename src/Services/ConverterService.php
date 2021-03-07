<?php
namespace App\Services;

use App\Interfaces\ApiInterface;
use App\Interfaces\ConvertInterface;

class ConverterService implements ConvertInterface
{

    /**
     * @var
     */
    private $convertedAmount;

    /**
     * @var ApiInterface
     */
    private $api;

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
     * @param $amount
     * @param $currency
     * @return float
     */
    public function convert($amount, $currency): float
    {
        $rates = $this->api->handleApiData()->rates;

        foreach ($rates as $rate => $value) {
            if ($rate === $currency) {
                $this->convertedAmount = $amount / $value;
            }
        }

        return round($this->convertedAmount, 2);
    }
}