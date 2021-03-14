<?php
namespace App\Interfaces;

use Evp\Component\Money\Money;

interface ConvertInterface
{
    public function convert(Money $amount): Money;
}