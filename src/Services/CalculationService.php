<?php
namespace App\Services;

use App\EnumTypes\OperationType;
use App\EnumTypes\UserType;
use App\Interfaces\CalculationInterface;
use App\Interfaces\ConvertInterface;
use App\Model\Transaction;
use App\Model\UserTransaction;
use Carbon\Carbon;
use Evp\Component\Money\Money;

class CalculationService implements CalculationInterface
{
    const EUR = 'EUR';

    const LIMIT = '1000';

    /**
     * @var array
     */
    private array $commissionFee = [];

    /**
     * @param array $transactionData
     * @param array $userTransactions
     * @return array
     * @throws \Exception
     */
    public function calculate(array $transactionData, $userTransactions): array
    {
        /** @var Transaction $data */
        foreach ($transactionData as $data) {
            switch ($data->getOperationType())
            {
                case OperationType::DEPOSIT:
                    $this->commissionFee[] = $this->calculateDepositCommission($data);
                    break;
                case OperationType::WITHDRAW:
                    $this->commissionFee[] = $this->calculateWithdrawCommission($data,$userTransactions);
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
        return $data->getOperationAmount()->mul(OperationType::DEPOSIT_FEE)->div(100);
    }

    /**
     * @param Transaction $data
     *
     * @return string
     */
    private function calculateWithdrawCommission(Transaction $data,$userTransactions): string
    {
        if ($data->getUserType() === UserType::PRIVATE_CLIENT) {
              return $amount = $data->getOperationAmount()->mul(OperationType::WITHDRAW_PRIVATE_CLIENT_FEE)->div(100);
        }

        return $data->getOperationAmount()->mul(OperationType::WITHDRAW_BUSINESS_CLIENT_FEE)->div(100);
    }

}