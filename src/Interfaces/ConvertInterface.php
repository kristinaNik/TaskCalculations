<?php
namespace App\Interfaces;

interface ConvertInterface
{
    public function convert(float $amount,  string $currency): float;
}