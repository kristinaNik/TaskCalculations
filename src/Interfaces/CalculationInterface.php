<?php
namespace App\Interfaces;

interface CalculationInterface
{
    public function calculate(array $transactionData, array $filterById): array;
}