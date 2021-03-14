<?php
namespace App\Services;

use App\EnumTypes\OperationType;
use App\EnumTypes\UserType;
use App\Handlers\ConfigHandler;
use App\Interfaces\CalculationInterface;
use App\Interfaces\ConvertInterface;
use App\Model\Transaction;
use App\Model\UserTransaction;
use Evp\Component\Money\Money;

class CalculationService implements CalculationInterface
{
    const EUR = 'EUR';

    const LIMIT = 1000;

    private $configHandler;

    /**
     * @var array
     */
    private array $commissionFee = [];


    public function __construct()
    {
        $this->configHandler = ConfigHandler::handleConfiguration();
    }

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
        return $data->getOperationAmount()->mul($this->configHandler->getDepositFee())->div(100);
    }

    /**
     * @param Transaction $data
     *
     * @return string
     */
    private function calculateWithdrawCommission(Transaction $data,$userTransactions): string
    {
        if ($data->getUserType() === UserType::PRIVATE_CLIENT) {
//            if($this->getTotalAmount($data,$userTransactions)->isLte(Money::create(self::LIMIT, self::EUR))) {
//                return Money::createZero(self::EUR);
//            };

            return $amount = $data->getOperationAmount()->mul($this->configHandler->getWithdrawPrivateClientFee())->div(100);
        }

        return $data->getOperationAmount()->mul($this->configHandler->getWithdrawBusinessClientFee())->div(100);
    }

    /**
     * @param $userTransactions
     *
     * @return
     */
    public function getTotalAmount(Transaction $data,$userTransactions)
    {
            $totalAmount = Money::createZero(self::EUR);
            /** @var UserTransaction $userTransaction */
            foreach ($userTransactions as $userTransaction) {
                if ($data->getUserId() === key($userTransactions)) {
                    $totalAmount = $userTransaction->getTotalAmount();
                }
            }

            return $totalAmount;
    }
}