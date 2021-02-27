<?php


namespace App\Services;

use App\Interfaces\ApiInterface;

class ConverterService
{

    private $convertedAmount;

    private $api;

    public function __construct(ApiInterface $api)
    {
        $this->api = $api;
    }


    /**
     * @param $amount
     * @param $currency
     * @return float|int
     */
    public function convert($amount, $currency)
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