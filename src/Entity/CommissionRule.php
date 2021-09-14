<?php

declare(strict_types=1);

namespace App\Entity;

use Evp\Component\Money\Money;

class CommissionRule
{
    private ?string $userType;

    private ?string $operationType;

    private ?string $feePercentage;

    private ?Money $discountWeeklyAmountLimit;

    private ?int $discountWeeklyCountLimit;

    private ?Money $maxCommission;

    private ?Money $fixedCommission;

    private ?int $userId;

    public function __construct()
    {
        $this->userType = null;
        $this->operationType = null;
        $this->feePercentage = null;
        $this->discountWeeklyAmountLimit = null;
        $this->discountWeeklyCountLimit = null;
        $this->userId = null;
    }

    public function getUserType(): ?string
    {
        return $this->userType;
    }

    public function getOperationType(): ?string
    {
        return $this->operationType;
    }

    public function getFeePercentage(): ?string
    {
        return $this->feePercentage;
    }

    public function setUserType(string $userType): self
    {
        $this->userType = $userType;
        return $this;
    }

    public function setOperationType(string $operationType): self
    {
        $this->operationType = $operationType;
        return $this;
    }

    public function setFeePercentage(string $feePercentage): self
    {
        $this->feePercentage = $feePercentage;
        return $this;
    }

    public function getDiscountWeeklyAmountLimit(): ?Money
    {
        return $this->discountWeeklyAmountLimit;
    }

    public function setDiscountWeeklyAmountLimit(Money $discountWeeklyAmountLimit): self
    {
        $this->discountWeeklyAmountLimit = $discountWeeklyAmountLimit;
        return $this;
    }

    public function getDiscountWeeklyCountLimit(): ?int
    {
        return $this->discountWeeklyCountLimit;
    }

    public function setDiscountWeeklyCountLimit(int $discountWeeklyCountLimit): self
    {
        $this->discountWeeklyCountLimit = $discountWeeklyCountLimit;
        return $this;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): self
    {
        $this->userId = $userId;
        return $this;
    }
}
