<?php


namespace App\Factories;


use App\Model\Transaction;

class TransactionFactory
{
    /**
     * @param $date
     * @param $userId
     * @param $userType
     * @param $operationType
     * @param $operationAmount
     * @param $operationCurrency
     * @return Transaction
     */
    public static function createTransaction($date, $userId, $userType, $operationType, $operationAmount, $operationCurrency): Transaction
    {
        return new Transaction($date, $userId, $userType, $operationType, $operationAmount, $operationCurrency);

    }
}