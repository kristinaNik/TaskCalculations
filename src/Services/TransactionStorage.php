<?php

declare(strict_types=1);

namespace App\Services;

use App\Entity\Transaction;
use DateTime;
use Evp\Component\Money\Money;

class TransactionStorage
{
    private CurrencyConverter $converter;
    private array $transactions;
    private string $baseCurrency;

    public function __construct(CurrencyConverter $converter, string $baseCurrency = 'EUR')
    {
        $this->converter = $converter;
        $this->transactions = [];
        $this->baseCurrency = $baseCurrency;
    }

    public function addTransaction(Transaction $transaction): void
    {
        $this->transactions[] = clone $transaction;
    }

    public function getWeeklyCount(Transaction $transaction): int
    {
        $count = 0;
        $weekNumber = $this->getWeekNumberInAYear($transaction->getDate());
        foreach ($this->transactions as $currentTransaction) {
            if (
                $currentTransaction->getUserId() === $transaction->getUserId()
                && $weekNumber === $this->getWeekNumberInAYear($currentTransaction->getDate())
                && $currentTransaction->getOperationType() === $transaction->getOperationType()
            ) {
                $count++;
            }
        }

        return $count;
    }

    /**
     * @param Transaction $transaction
     * @return Money
     */
    public function getWeeklyAmount(Transaction $transaction): Money
    {
        $totalAmount = Money::createZero($this->baseCurrency);
        $weekNumber = $this->getWeekNumberInAYear($transaction->getDate());

        foreach ($this->transactions as $currentTransaction) {
            if (
                $weekNumber === $this->getWeekNumberInAYear($currentTransaction->getDate())
                && $currentTransaction->getUserId() === $transaction->getUserId()
                && $currentTransaction->getOperationType() === $transaction->getOperationType()
            ) {
                $totalAmount = $totalAmount->add(
                    $this->converter->convert(
                        $currentTransaction->getOperationAmount(),
                        $this->baseCurrency
                    )
                );
            }
        }

        return $totalAmount;
    }

    public function getWeekNumberInAYear(DateTime $date): string
    {
        return $date->format('oW');
    }
}
