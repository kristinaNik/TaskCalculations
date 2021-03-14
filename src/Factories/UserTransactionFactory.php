<?php


namespace App\Factories;


use App\Model\UserTransaction;

class UserTransactionFactory
{

    public static function createUserTransaction($userId, $transactions, $totalAmount, $date)
    {
        return new UserTransaction($userId, $transactions, $totalAmount, $date);
    }

}