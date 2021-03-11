<?php
namespace App\Services;

use App\EnumTypes\OperationType;
use App\EnumTypes\UserType;
use App\Interfaces\CalculationInterface;
use App\Interfaces\ConvertInterface;
use App\Model\Transaction;

class CalculationService implements CalculationInterface
{
    const EUR = 'EUR';

    /**
     * @var array
     */
    private array $commissionFee = [];

    /**
     * @var ConvertInterface
     */
    private ConvertInterface $converter;

    /**
     * CalculationService constructor.
     *
     * @param ConvertInterface $converter
     */
    public function __construct(ConvertInterface $converter)
    {
        $this->converter = $converter;
    }

    /**
     * Calculate each transaction depending on the operationType
     *
     * @param array $transactionData
     * @param array $filterById
     *
     * @return array
     */
    public function calculate(array $transactionData, array $filterById): array
    {
        /** @var Transaction $data */
        foreach ($transactionData as $data) {
            switch ($data->getOperationType())
            {
                case OperationType::DEPOSIT:
                    $this->commissionFee[] = $this->calculateDepositCommission($data);
                    break;
                case OperationType::WITHDRAW && $data->getOperationCurrency() === self::EUR:
                    $this->commissionFee[] = $this->calculateWithdrawCommission($data, $filterById);
                    break;
               default:
                    $this->commissionFee[] = $this->converter->convert($data->getOperationAmount(), $data->getOperationCurrency(),OperationType::WITHDRAW_PRIVATE_CLIENT_FEE );
            }

        }

       return $this->commissionFee;
    }


    /**
     * @param Transaction $data
     *
     * @return string
     */
    private function calculateDepositCommission(Transaction $data): string
    {
        return number_format(($data->getOperationAmount() * OperationType::DEPOSIT_FEE) / 100, 2);
    }

    /**
     * @param Transaction $data
     * @param array $filterById
     *
     * @return string
     */
    private function calculateWithdrawCommission(Transaction $data, array $filterById): string
    {
        if ($data->getUserType() === UserType::PRIVATE_CLIENT) {
            //Check the date corresponding to the userId
            if (in_array($data->getDate(), $filterById)) {
                return number_format(0, 2);
            }
            return number_format(($data->getOperationAmount() * OperationType::WITHDRAW_PRIVATE_CLIENT_FEE) / 100, 2);
        }

        return number_format(($data->getOperationAmount() * OperationType::WITHDRAW_BUSINESS_CLIENT_FEE) / 100,2);
    }
}