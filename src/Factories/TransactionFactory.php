<?php
namespace App\Factories;

use App\Model\Transaction;
use Evp\Component\Money\Money;

class TransactionFactory
{
    /**
     * @param $date
     * @param $userId
     * @param $userType
     * @param $operationType
     * @param $operationAmount
     * @param $operationCurrency
     *
     * @return Transaction
     */
    public static function createTransaction(string $date, int $userId, string $userType, string $operationType, Money $operationAmount): Transaction
    {
        return new Transaction($date, $userId, $userType, $operationType, $operationAmount);

    }
}