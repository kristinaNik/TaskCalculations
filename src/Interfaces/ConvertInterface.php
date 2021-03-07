<?php
namespace App\Interfaces;

interface ConvertInterface
{
    public function convert($amount, $currency): float;
}