<?php
namespace App\Services;

use App\Interfaces\ApiInterface;
use App\Interfaces\ConvertInterface;
use Evp\Component\Money\Money;

class ConverterService implements ConvertInterface
{
    /**
     * @var
     */
    private  $convertedAmount;

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
     * @param Money $amount

     *
     * @return Money
     */
    public function convert(Money $amount): Money
    {
        $rates = $this->rates->getRates();
        foreach ($rates as $rate => $value) {
            if ($rate === $amount->getCurrency()) {
                $this->convertedAmount = $amount->div($value);
            }
        }
        $this->convertedAmount->setCurrency('EUR');

        return $this->convertedAmount;
    }
}