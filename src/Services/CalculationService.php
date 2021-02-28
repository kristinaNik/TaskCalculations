<?php
namespace App\Services;

use App\EnumTypes\OperationType;
use App\EnumTypes\UserType;
use App\Interfaces\CalculationInterface;
use App\Model\Transaction;

class CalculationService implements CalculationInterface
{
    const EUR = 'EUR';

    /**
     * @var array
     */
    private $commissionFee = [];

    /**
     * @var ConverterService
     */
    private $converter;


    /**
     * CalculationService constructor.
     * @param ConverterService $converter
     */
    public function __construct(ConverterService $converter)
    {
        $this->converter = $converter;
    }

    /**
     * Calculate each transaction depending on the operationType
     *
     * @param array $transactionData
     * @return array
     */
    public function calculate(array $transactionData): array
    {
        /** @var Transaction $data */
        foreach ($transactionData as $data) {
            switch ($data->getOperationType())
            {
                case OperationType::DEPOSIT:
                    $this->commissionFee[] = $this->calculateDepositCommission($data->getOperationAmount());
                    break;
                case OperationType::WITHDRAW && $data->getOperationCurrency() === self::EUR:
                    $this->commissionFee[] = $this->calculateWithdrawCommission($data->getUserType(),$data->getOperationAmount());
                    break;
                default:
                    $this->commissionFee[] = $this->convertAmount($data);
            }
        }

       return $this->commissionFee;
    }

    /**
     * @param Transaction $data
     *
     * @return float|int
     */
    private function convertAmount(Transaction $data)
    {
        $convertedAmount = $this->converter->convert($data->getOperationAmount(), $data->getOperationCurrency());

        return number_format(($convertedAmount * OperationType::WITHDRAW_PRIVATE_CLIENT_FEE) / 100, 2);
    }


    /**
     * @param $amount
     *
     * @return float|int
     */
    private function calculateDepositCommission($amount)
    {
        return number_format(($amount * OperationType::DEPOSIT_FEE) / 100, 2);
    }

    /**
     * @param $userType
     * @param $amount
     *
     * @return float|int
     */
    private function calculateWithdrawCommission($userType, $amount)
    {
        if ($userType === UserType::PRIVATE_CLIENT) {

            return number_format(($amount * OperationType::WITHDRAW_PRIVATE_CLIENT_FEE) / 100, 2);
        }

        return number_format(($amount * OperationType::WITHDRAW_BUSINESS_CLIENT_FEE) / 100,2);
    }
}