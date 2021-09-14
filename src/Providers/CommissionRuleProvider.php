<?php

declare(strict_types=1);

namespace App\Providers;

use App\Entity\CommissionRule;
use App\Entity\Transaction;
use Evp\Component\Money\Money;

class CommissionRuleProvider
{
    /**
     * @var CommissionRule[]
     */
    private array $commissionRules = [];


    /**
     * @param Transaction $transaction
     * @return CommissionRule
     */
    public function provideCommissionRule(Transaction $transaction): CommissionRule
    {
        $rule = null;

        foreach ($this->getCommissionRules() as $commissionRule) {
            if (
                $rule === null
                && $transaction->getOperationType() === $commissionRule->getOperationType()
                && $transaction->getUserType() === $commissionRule->getUserType()
            ) {
                $rule = $commissionRule;
            }

            if ($transaction->getUserId() === $commissionRule->getUserId()) {
                return $commissionRule;
            }
        }

        return $rule;
    }

    /**
     * @return CommissionRule[]
     */
    public function getCommissionRules(): array
    {
        return $this->commissionRules = [
            (new CommissionRule())
                ->setFeePercentage('0.3')
                ->setOperationType('withdraw')
                ->setUserType('private')
                ->setDiscountWeeklyAmountLimit(new Money(1000, 'EUR'))
                ->setDiscountWeeklyCountLimit(3),
            (new CommissionRule())
                ->setFeePercentage('0.5')
                ->setOperationType('withdraw')
                ->setUserType('business'),
            (new CommissionRule())
                ->setFeePercentage('0.03')
                ->setOperationType('deposit')
                ->setUserType('business'),
            (new CommissionRule())
                ->setFeePercentage('0.03')
                ->setOperationType('deposit')
                ->setUserType('private'),
        ];
    }
}
