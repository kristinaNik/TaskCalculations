<?php

declare(strict_types=1);

namespace App\Tests;

use App\Entity\CommissionRule;
use App\Entity\Transaction;
use App\Providers\CommissionRuleProvider;
use App\Services\Calculator;
use App\Services\CurrencyConverter;
use App\Services\TransactionStorage;
use DateTime;
use Evp\Component\Money\Money;
use PHPUnit\Framework\TestCase;

class CalculatorTest extends TestCase
{
    /**
     * @dataProvider calculateCommissionsProvider
     * @param Money $expectedCommission
     * @param string $exchangeRate
     * @param Transaction $transaction
     * @param int $weeklyTransactionCount
     * @param Money $weeklyTransactionAmount
     * @param CommissionRule $commissionRule
     */
    public function testCommissionsAreCalculated(
        Money $expectedCommission,
        string $exchangeRate,
        Transaction $transaction,
        int $weeklyTransactionCount,
        Money $weeklyTransactionAmount,
        CommissionRule $commissionRule
    ): void {
        $currencyConverter = $this->createMock(CurrencyConverter::class);
        $currencyConverter
            ->method('convert')
            ->willReturnCallback(
                function (Money $amount, string $currencyTo) use ($exchangeRate) {
                    return $amount->mul($exchangeRate)->setCurrency($currencyTo);
                }
            )
        ;

        $commissionRuleProvider = $this->createMock(CommissionRuleProvider::class);
        $commissionRuleProvider->expects($this->once())
            ->method('provideCommissionRule')
            ->willReturn($commissionRule)
        ;

        $transactionStorage = $this->createMock(TransactionStorage::class);

        $transactionStorage
            ->expects($this->any())
            ->method('getWeeklyCount')
            ->willReturn($weeklyTransactionCount)
        ;

        $transactionStorage
            ->expects($this->any())
            ->method('getWeeklyAmount')
            ->willReturn($weeklyTransactionAmount)
        ;

        $calculator = new Calculator($currencyConverter, $transactionStorage, $commissionRuleProvider);
        $transactionClone = clone $transaction;

        $actualCommission = $calculator->calculate($transactionClone);

        $this->assertEquals($transaction, $transactionClone);
        $this->assertEquals($expectedCommission, $actualCommission);
    }

    public function calculateCommissionsProvider(): array
    {
        return [
            'test withdraw transaction made in euro for private client' => [
                'expectedCommission' => new Money('0.60', 'EUR'),
                'exchangeRate' => '1',
                'transaction' => new Transaction(
                    new DateTime('2014-12-31'),
                    4,
                    'private',
                    'withdraw',
                    new Money(1200, 'EUR')
                ),

                'weeklyTransactionCount' => 1,
                'weeklyTransactionAmount' => new Money(1200, 'EUR'),
                'commissionRule' => (new CommissionRule())
                    ->setUserType('private')
                    ->setOperationType('withdraw')
                    ->setFeePercentage('0.3')
                    ->setDiscountWeeklyAmountLimit(new Money(1000, 'EUR'))
                    ->setDiscountWeeklyCountLimit(3),
            ],
            'test withdraw transaction made in JPY for private client' => [
                'expectedCommission' => new Money('8612', 'JPY'),
                'exchangeRate' => '129.53',
                'transaction' => new Transaction(
                    new DateTime('2016-02-19'),
                    5,
                    'private',
                    'withdraw',
                    new Money(3000000, 'JPY')
                ),

                'weeklyTransactionCount' => 1,
                'weeklyTransactionAmount' => new Money(23160, 'EUR'),
                'commissionRule' => (new CommissionRule())
                    ->setUserType('private')
                    ->setOperationType('withdraw')
                    ->setFeePercentage('0.3')
                    ->setDiscountWeeklyAmountLimit(new Money(1000, 'EUR'))
                    ->setDiscountWeeklyCountLimit(3),
            ],
            'test withdraw transaction made in JPY with partial discount for private client' => [
                'expectedCommission' => new Money('78', 'JPY'),
                'exchangeRate' => '129.53',
                'transaction' => new Transaction(
                    new DateTime('2016-02-19'),
                    5,
                    'private',
                    'withdraw',
                    new Money(103624, 'JPY')
                ),

                'weeklyTransactionCount' => 2,
                'weeklyTransactionAmount' => new Money(1200, 'EUR'),
                'commissionRule' => (new CommissionRule())
                    ->setUserType('private')
                    ->setOperationType('withdraw')
                    ->setFeePercentage('0.3')
                    ->setDiscountWeeklyAmountLimit(new Money(1000, 'EUR'))
                    ->setDiscountWeeklyCountLimit(3),
            ],
            'test withdraw transaction made in JPY with full discount for private client' => [
                'expectedCommission' => new Money('0', 'JPY'),
                'exchangeRate' => '129.53',
                'transaction' => new Transaction(
                    new DateTime('2016-02-19'),
                    5,
                    'private',
                    'withdraw',
                    new Money(129.53, 'JPY')
                ),

                'weeklyTransactionCount' => 1,
                'weeklyTransactionAmount' => new Money(1, 'EUR'),
                'commissionRule' => (new CommissionRule())
                    ->setUserType('private')
                    ->setOperationType('withdraw')
                    ->setFeePercentage('0.3')
                    ->setDiscountWeeklyAmountLimit(new Money(1000, 'EUR'))
                    ->setDiscountWeeklyCountLimit(3),
            ],
            'test withdraw transaction made in USD with partial discount for private clients' => [
                'expectedCommission' => new Money('0.30', 'USD'),
                'exchangeRate' => '1.1497',
                'transaction' => new Transaction(
                    new DateTime('2016-01-07'),
                    1,
                    'private',
                    'withdraw',
                    new Money(100, 'USD')
                ),

                'weeklyTransactionCount' => 3,
                'weeklyTransactionAmount' => new Money(1086.97, 'EUR'),
                'commissionRule' => (new CommissionRule())
                    ->setUserType('private')
                    ->setOperationType('withdraw')
                    ->setFeePercentage('0.3')
                    ->setDiscountWeeklyAmountLimit(new Money(1000, 'EUR'))
                    ->setDiscountWeeklyCountLimit(3),
            ],
            'test withdraw transaction made in euro with partial discount for private clients' => [
                'expectedCommission' => new Money('0.70', 'EUR'),
                'exchangeRate' => '1',
                'transaction' => new Transaction(
                    new DateTime('2016-01-07'),
                    2,
                    'private',
                    'withdraw',
                    new Money(1000, 'EUR')
                ),

                'weeklyTransactionCount' => 2,
                'weeklyTransactionAmount' => new Money(1231, 'EUR'),
                'commissionRule' => (new CommissionRule())
                    ->setUserType('private')
                    ->setOperationType('withdraw')
                    ->setFeePercentage('0.3')
                    ->setDiscountWeeklyAmountLimit(new Money(1000, 'EUR'))
                    ->setDiscountWeeklyCountLimit(3),
            ],
            'test withdraw transaction made in euro for business client' => [
                'expectedCommission' => new Money('1.50', 'EUR'),
                'exchangeRate' => '1',
                'transaction' => new Transaction(
                    new DateTime('2016-01-05'),
                    2,
                    'business',
                    'withdraw',
                    new Money(300, 'EUR')
                ),

                'weeklyTransactionCount' => 0,
                'weeklyTransactionAmount' => new Money(0, 'EUR'),
                'commissionRule' => (new CommissionRule())
                    ->setUserType('business')
                    ->setOperationType('withdraw')
                    ->setFeePercentage('0.5'),
            ],
            'test deposit transaction made in euro for business client' => [
                'expectedCommission' => new Money('0.06', 'EUR'),
                'exchangeRate' => '1',
                'transaction' => new Transaction(
                    new DateTime('2016-01-05'),
                    2,
                    'business',
                    'deposit',
                    new Money(200, 'EUR')
                ),

                'weeklyTransactionCount' => 0,
                'weeklyTransactionAmount' => new Money(0, 'EUR'),
                'commissionRule' => (new CommissionRule())
                    ->setUserType('business')
                    ->setOperationType('deposit')
                    ->setFeePercentage('0.03'),
            ],
        ];
    }
}
