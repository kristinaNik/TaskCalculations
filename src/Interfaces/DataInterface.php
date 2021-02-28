<?php
namespace App\Interfaces;

interface DataInterface
{
    public function getTransactions(array $fileData): array;
}