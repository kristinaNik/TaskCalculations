<?php
namespace App\Services;

use App\EnumTypes\OperationType;
use App\EnumTypes\UserType;
use App\Interfaces\CalculationInterface;
use App\Interfaces\ConvertInterface;
use App\Model\Transaction;
use Carbon\Carbon;

class CalculationService implements CalculationInterface
{
    const EUR = 'EUR';

    const LIMIT = 1000;

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
     * @param ConvertInterface $converter
     */
    public function __construct( ConvertInterface $converter)
    {
        $this->converter = $converter;
    }


    /**
     * @param array $transactionData
     * @param array $filterById
     * @return array
     * @throws \Exception
     */
    public function calculate(array $transactionData, $filterById): array
    {
        /** @var Transaction $data */
        foreach ($transactionData as $data) {
            switch ($data->getOperationType())
            {
                case OperationType::DEPOSIT:
                    $this->commissionFee[] = $this->calculateDepositCommission($data);
                    break;
                case OperationType::WITHDRAW:
                    $this->commissionFee[] = $this->calculateWithdrawCommission($data);
                    break;
               default:
                  throw new \Exception("No such operation exists");
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
     *
     * @return string
     */
    private function calculateWithdrawCommission(Transaction $data): string
    {
        if ($data->getUserType() === UserType::PRIVATE_CLIENT) {
            if ($data->getOperationCurrency() != self::EUR) {
                $amount = $this->converter->convert($data->getOperationAmount(), $data->getOperationCurrency());
            } else {
                $amount = $data->getOperationAmount();
            }
            return number_format(($amount * OperationType::WITHDRAW_PRIVATE_CLIENT_FEE) / 100, 2);
        }

        return number_format(($data->getOperationAmount() * OperationType::WITHDRAW_BUSINESS_CLIENT_FEE) / 100,2);
    }
}