<?php

namespace App\Entity;

use DateTime;
use Evp\Component\Money\Money;

class Transaction
{
    const OPERATION_TYPE_WITHDRAW = 'withdraw';
    const OPERATION_TYPE_DEPOSIT = 'deposit';
    const USER_TYPE_BUSINESS = 'business';
    const USER_TYPE_PRIVATE = 'private';

    public static array $availableOperationTypes = [
        self::OPERATION_TYPE_WITHDRAW,
        self::OPERATION_TYPE_DEPOSIT,
    ];

    public static array $availableUserTypes = [
        self::USER_TYPE_BUSINESS,
        self::USER_TYPE_PRIVATE,
    ];

    private DateTime $date;

    private int $userId;

    private string $userType;

    private string $operationType;

    private Money $operationAmount;

    public function __construct(
        DateTime $date,
        int $userId,
        string $userType,
        string $operationType,
        Money $operationAmount
    ) {
        $this->date = $date;
        $this->userId = $userId;
        $this->userType = $userType;
        $this->operationType = $operationType;
        $this->operationAmount = $operationAmount;
    }

    public function getDate(): DateTime
    {
        return $this->date;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getUserType(): string
    {
        return $this->userType;
    }

    public function getOperationType(): string
    {
        return $this->operationType;
    }

    public function getOperationAmount(): Money
    {
        return $this->operationAmount;
    }

    public function setOperationAmount(Money $operationAmount): self
    {
        $this->operationAmount = $operationAmount;
        return $this;
    }

}
