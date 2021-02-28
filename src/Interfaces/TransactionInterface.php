<?php
namespace App\Interfaces;

interface TransactionInterface
{
    public function getTransactions(array $fileData): array;
}