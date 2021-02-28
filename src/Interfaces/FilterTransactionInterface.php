<?php
namespace App\Interfaces;

interface FilterTransactionInterface
{
    public function filterTransactionById(array $fileData): array;
}