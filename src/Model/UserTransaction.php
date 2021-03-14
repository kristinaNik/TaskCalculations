<?php


namespace App\Model;


use Evp\Component\Money\Money;

class UserTransaction
{

    private $userId;

    private $transactions;

    private $totalAmount;

    private $date;



    public function __construct($userId, int $transactions, Money $totalAmount, string $date)
    {
        $this->userId = $userId;
        $this->transactions = $transactions;
        $this->totalAmount = $totalAmount;
        $this->date = $date;

    }
    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @return int
     */
    public function getTransactions(): int
    {
        return $this->transactions;
    }

    /**
     * @return string
     */
    public function getDate(): string
    {
        return $this->date;
    }


    public function getTotalAmount(): Money
    {
        return  $this->totalAmount;
    }

}