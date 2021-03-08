<?php
namespace App\Model;

class Transaction
{
    /**
     * @var string
     */
    private string $date;

    /**
     * @var int
     */
    private int $userId;

    /**
     * @var string
     */
    private string $userType;

    /**
     * @var string
     */
    private string $operationType;

    /**
     * @var float
     */
    private float $operationAmount;

    /**
     * @var string
     */
    private string $operationCurrency;

    /**
     * Transaction constructor.
     *
     * @param string $date
     * @param int $userId
     * @param string $userType
     * @param string $operationType
     * @param float $operationAmount
     * @param string $operationCurrency
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
    public function getOperationAmount(): float
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