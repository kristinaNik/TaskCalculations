<?php


namespace App\Model;


class Transaction
{
    private $date;
    private $userId;
    private $userType;
    private $operationType;
    private $operationAmount;
    private $operationCurrency;

    /**
     * DataDto constructor.
     *
     * @param $date
     * @param $userId
     * @param $userType
     * @param $operationType
     * @param $operationAmount
     * @param $operationCurrency
     */
    public function __construct(string $date, int $userId, string $userType, string $operationType, float $operationAmount, string $operationCurrency)
    {
        $this->date = $date;
        $this->userId = $userId;
        $this->userType = $userType;
        $this->operationType = $operationType;
        $this->operationAmount = $operationAmount;
        $this->operationCurrency = $operationCurrency;
    }

    /**
     * @return mixed
     */
    public function getDate(): string
    {
        return $this->date;
    }

    /**
     * @return mixed
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @return mixed
     */
    public function getUserType(): string
    {
        return $this->userType;
    }

    /**
     * @return mixed
     */
    public function getOperationType(): string
    {
        return $this->operationType;
    }

    /**
     * @return mixed
     */
    public function getOperationAmount(): string
    {
        return $this->operationAmount;
    }

    /**
     * @return mixed
     */
    public function getOperationCurrency(): string
    {
        return $this->operationCurrency;
    }

}