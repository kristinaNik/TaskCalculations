<?php


namespace App\Services;


use Evp\Component\Money\Money;

class CommissionRules
{
    private $feeRate;

    public function __construct(float $feeRate)
    {
        $this->feeRate = $feeRate;
    }

    public function apply(Money $totalAmount): Money
    {
        $amountToBeTaxed = 0;

        if ($totalAmount->isGte(Money::create(1000))) {
            $amountToBeTaxed = $totalAmount->sub(Money::create(1000));
        }
        return $amountToBeTaxed->mul($this->feeRate);
    }
}