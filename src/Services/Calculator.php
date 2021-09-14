<?php

namespace App\Services;

use App\Entity\CommissionRule;
use App\Entity\Transaction;
use App\Providers\CommissionRuleProvider;
use Evp\Component\Money\Money;

class Calculator
{
    private TransactionStorage $transactionStorage;

    private CommissionRuleProvider $commissionRuleProvider;

    private CurrencyConverter $converter;

    public function __construct(
        TransactionStorage $transactionStorage,
        CommissionRuleProvider $commissionRuleProvider,
        CurrencyConverter $converter
    ){
        $this->transactionStorage = $transactionStorage;
        $this->commissionRuleProvider = $commissionRuleProvider;
        $this->converter = $converter;
    }

    /**
     * @param Transaction $transaction
     * @return Money
     */
    public function calculate(Transaction $transaction): Money
    {
        $this->transactionStorage->addTransaction($transaction);
        $rule = $this->commissionRuleProvider->provideCommissionRule($transaction);
        $weeklyCount = $this->transactionStorage->getWeeklyCount($transaction);
        $weeklyAmount = $this->transactionStorage->getWeeklyAmount($transaction);

        if ($rule->getDiscountWeeklyCountLimit() !== null && $weeklyCount <= $rule->getDiscountWeeklyCountLimit()) {
            if ($weeklyAmount->isLte($rule->getDiscountWeeklyAmountLimit())) {
                return Money::createZero($transaction->getOperationAmount()->getCurrency());
            }
            $amountOverTheLimit = $this->getAmountOverTheLimit($transaction, $rule);
            if ($transaction->getOperationAmount()->isGt($amountOverTheLimit)) {
                $clonedTransaction = clone $transaction;
                return $this->calculateCommissions($clonedTransaction->setOperationAmount($amountOverTheLimit), $rule);
            }

        }

        return $this->calculateCommissions($transaction, $rule);
    }

    /**
     * @param Transaction $transaction
     * @param CommissionRule $rule
     * @return Money
     */
    private function getAmountOverTheLimit(Transaction $transaction, CommissionRule $rule): Money
    {
        $weeklyAmount = $this->transactionStorage->getWeeklyAmount($transaction);
        $amountOverTheLimit = $weeklyAmount->sub($rule->getDiscountWeeklyAmountLimit());

        return $this->converter->convert($amountOverTheLimit, $transaction->getOperationAmount()->getCurrency());
    }

    /**
     * @param Transaction $transaction
     * @param CommissionRule $rule
     * @return Money
     */
    private function calculateCommissions(Transaction $transaction, CommissionRule $rule): Money
    {
        $commission = $transaction->getOperationAmount()->mul($rule->getFeePercentage())->div(100);

        return $commission->ceil();
    }
}
